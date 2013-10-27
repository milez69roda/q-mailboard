var oTable, group_data, subgroup_data;
var myModal;
var lock = false;
var currentGroup = '';
app = { 
	_init: function (){
		var d = new Date();
		$.getJSON('inbox/init_js_var/?'+d.getTime(), function (data) { 
			//group_data = data.group;
			subgroup_data = data.subgroup;
		});
	},
	
	onSelGroup : function (field, opt) {
		var gid = $(field).val();
		$("#selectSubGroup option").remove();
		$.each(subgroup_data[gid], function (val, text) {
			if( opt != val )
				$("#selectSubGroup").append($("<option/>").attr("value", val).text(text));
		});
	},
	
	group_option : function () {
		$.each(group_data, function (val, text) {
			$("#selectGroup").append($("<option/>").attr("value", text.id).text(text.group_name));
		});
	},	
	
	modal: function(title, content, redirect ){
		
		var tpl = '<div class="modal fade">'
				+'<div class="modal-dialog">'
					+'<div class="modal-content">'
						+'<div class="modal-header">'
						+'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>'
						+'<h4 class="modal-title">'+title+'</h4>'
						+'</div>'
						+'<div class="modal-body">'
							+content
						+'</div>'
						+'<div class="modal-footer">'
						+'<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>' 
					  +'</div>'
					+'</div>'
				  +'</div>'
				+'</div>';
				 
		$(tpl).modal().on('hidden.bs.modal', function () {
			if( redirect != '' ) window.location = redirect;  
		});
	},
	 
	//get mail content and display on the content area
	getMailContent: function(x, y, title){
			
			 
			$("#mail_content_container").html('fetching record!!!');
			lock = true;
			$.get('inbox/categorytpl/', {title:title}, function(html){ 
			 	  
					$("#mail_content_container").html(html); 
					//fetching data on the table
					oTable = $('#mail_table_list').dataTable({ 
						"sDom": "<'row'<'pull-right'f><'pull-left'l>r<'clearfix'>>t<'row'<'pull-left'i><'pull-right'p><'clearfix'>>",
						"sPaginationType": "bootstrap", 
						"bProcessing": true,
						"bServerSide": true,
						"sAjaxSource": "inbox/category_ajax_list",
						"bPaginate": true,		 
						"oLanguage": {
							"sLengthMenu": "Show _MENU_ Rows",
							"sSearch": "Search: "
						},						
						"iDisplayLength": 10,
						"aaSorting": [[ 4, 'desc' ]],
						"aoColumnDefs":[
							{ 'bSortable': false, 'aTargets': [ 0 ]}
						],
						"fnServerParams": function( aoData ){
							aoData.push( { "name": "gidx", "value": x } ); 
							aoData.push( { "name": "gidy", "value": y } ); 
						}						
					}); 
					
					app.rebuild_sidebar(x);
			});   
			
	},
	
	openMail: function(gid,x){
		
		var d = new Date(); 
		var content = $('<div class="modal" id="myModalOpenMail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" ></div>').load('inbox/get_mail_content/?_t='+d.getTime(), {x:x});
		  
		myModal = $(content).modal({
			backdrop: false,
			show: true
		});
		
		myModal.on('hidden.bs.modal', function(){			 
			$(this).remove();
			app.rebuild_sidebar(gid);
		}); 
		 
		oTable.fnDraw(); 
				 
	},
	
	markRead: function(x){
	 
		$.post('inbox/markread',{x:x}, function(json){
			//console.log(json);
		});
	},
	
	answerMail: function(form){
		 
		if( confirm("Please confirm this operation") ){
			var gid = $('#'+form.id).find('#h_mail_g').val();
			$.ajax({
				type: 'post',
				url: 'inbox/send',
				data: $(form).serialize(),
				dataType:'json',
				success: function(json){
					
					myModal.modal('hide');
					app.modal('Success', json.msg, '');
					oTable.fnDraw(); 
					app.rebuild_sidebar(gid);
				}
			});
		} 
		return false;
	},
	
	optionsEnable: function(option, form, field){ 
		var title = '';
		
		form = $('#'+form); 
		form.find('#h_mail_option').val(option);
		
		//set active for buttons
		form.find('.btn-group .btn-default').each(function(){
			$(this).removeClass('active');
		})
		$(field).addClass('active');
		form.find("#btn_send").show(); 
		 
		if( option == 'reply' ){				
			form.find('#div_txt_mail_body').hide();	
			form.find('#txt_mail_body').parent('div').show();	
			form.find('#txt_mail_answer').parent('div').show();	
			form.find('#forward_option').hide();	
			form.find('#sendtocenter').parent().parent('div').hide();						
			title = 'Reply to Center';
		}
		
		
		if( option == 'forward' ){		
			form.find('#div_txt_mail_body').show();	
			form.find('#txt_mail_body').parent('div').hide();
			form.find('#txt_mail_answer').parent('div').hide();				
			form.find('#forward_option').show();	
			form.find('#sendtocenter').parent().parent('div').hide();							
			title = 'Forward';
		}		
		
		if( option == 'post' ){		
			form.find('#div_txt_mail_body').hide();	
			form.find('#txt_mail_body').parent('div').show();	
			form.find('#txt_mail_answer').parent('div').show();				
			form.find('#forward_option').hide();				
			form.find('#sendtocenter').parent().parent('div').show();				
			title = 'Post to FAQ';
		}
		
		//change title
		$(field).parents('.modal-content').find('.modal-title').html('Mail - '+title);
		  
		
	},
	
	rebuild_sidebar: function(gid){
		
		$('#sidebar').load('inbox/rebuild_sidebar',{gid:gid});
		
	}
}


$(document).ready(function(){
	
	app._init();
	
	$('[data-toggle=offcanvas]').click(function() {
		$('.row-offcanvas').toggleClass('active');
	});
			   
	$(".collapse").collapse(); 
	
	//sidebar
	var sbar = $('#sidebar').find('[data-maillink]');
	
	sbar.click(function(event) {
		event.preventDefault();
		 lv = $(this).data('maillink').split(',');
		 app.getMailContent(lv[0], lv[1], lv[2]);
	});
	
	//toggle check and uncheck on the mail checkboxes
	$(document).on('click', '#m_r_check_option', function (){ 
		if( this.checked ){ 
			$('body').find('.m_r_check_c').each(function(){  
				this.checked = true;
			});  
        }else{        
			$('body').find('.m_r_check_c').each(function(){
				this.checked = false;		
			}); 			
        }
	});
	
	$(document).on("click", ".dataTable tbody tr", function(){
		/* var  id = (this.id).split("_");
		app.openMail(id[3]); */
	});
	
});

 