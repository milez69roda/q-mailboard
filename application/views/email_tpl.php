 
<div style="border: 1px solid #ccc; width:90%">
	 
	<h3 style="padding-left: 10px;">Send an Email</h3>
	<hr />	
	
	<div class="alert" style="color:red">
		<h4 style="text-decoration: underline">Notice:</h4>
		<small>
		<p>This email is for questions, comments, trends and concerns only. It is not for immediate specific customer resolution or actions. Email questions should be TracFone business related. Your email will be forwarded to TracFone Department Subject Matter Experts (SMEs) who will read and reply to your questions.   
		Turn around time for answers is 24 to 72 hours.</p>
		<p>Please note that emails are reviewed for professional/business content and are traceable back to the Care Center, ID, PC and Representative who sent it. </p>
		</small>
	</div>
	<br />  
	<form class="form-horizontal" role="form" name="email_form" id="email_form" onsubmit="return email.onSubmit(this);">
	 
		<div class="form-group">
			<label for="inputPassword1" class="col-lg-2 control-label pull-left">Firstname: <strong class="text-danger">*</strong></label>
			<div class="col-lg-2 pull-left">
			  <input type="text" class="form-control" id="inputFirstname" name="inputFirstname" placeholder="First Name">
			</div>

			<label for="inputPassword1" class="col-lg-2 control-label pull-left">Lastname: <strong class="text-danger">*</strong></label>
			<div class="col-lg-2 pull-left">
			  <input type="text" class="form-control" id="inputLastname" name="inputLastname" placeholder="Last Name">
			</div> 
		</div> 
		  
		<div class="form-group">
			<label for="inputPassword1" class="col-lg-2 control-label pull-left">Avaya: <strong class="text-danger">*</strong></label>
			<div class="col-lg-2 pull-left">
			  <input type="text" class="form-control" id="inputAyava" name="inputAyava" placeholder="Avaya">
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputPassword1" class="col-lg-2 control-label pull-left">To: <strong class="text-danger">*</strong></label>
			<div class="col-lg-10 pull-left">
				<select id="selectGroup" name="selectGroup" class="form-control pull-left" style="width: 180px !important" onchange="email.onSelGroup(this);">
					<option></option>
				</select>
				<select id="selectSubGroup" name="selectSubGroup" class="form-control pull-left"  style="width: 180px !important" onchange="email.onSelSubgroup(this)">
					<option></option>
				</select>
				<br class="clearfix" /><br />
				<a href="#" id="functionality" data-toggle="modal" data-target="#txtfunction" >Please click here to view functionalities of each department </a>
			</div>
		</div> 
		
		<div class="form-group">
			<label for="inputPassword1" class="col-lg-2 control-label pull-left" title="Required if other is selected">Subject:  <strong class="text-danger">*</strong></label>
			<div class="col-lg-6 pull-left">
			  <input type="text" class="form-control" id="inputSubjectOther" name="inputSubjectOther" placeholder="Subject" disabled>
			</div>
		</div>		 
		 	 
		<div class="form-group">
			<label class="col-lg-2 control-label pull-left" for="textMessage">Message: <strong class="text-danger">*</strong></label>
			<div class="col-lg-6 pull-left">
				<textarea class="form-control" rows="5" id="textMessage" name="textMessage"></textarea>
			</div>
		</div>
		 
		<div class="form-group"> 
			<label class="col-lg-2 control-label " for="submit_btn">&nbsp;</label>
			<div class="col-lg-offset col-lg-6">
				<button type="submit" name="submit_btn" class="btn btn-default">Send</button>
			</div>
		</div>
		
	</form>
	 
	<div class="modal fade"  id="txtfunction">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title">Functionalities of Each Department</h4>
		  </div>
		  <div class="modal-body" style="height: 500px; overflow:auto">
				<p><strong>Carrier Ops</strong> - Responsible for OTA, Carrier Line Inventory, Automated Service Provisioning (Integrate), Carrier Coverage and IVR Automation (transactions which allow the customer to self service themselves).</p>
				<p><strong>CRT</strong> - Responsible for ensuring that each phone is working properly, along with any other carrier related issue the customer may experience.</p>
				<p><strong>Direct Sales</strong> - Responsible for Credit Card Maintenance, Credit card Refund, Value Plan, Autopay, on Demand, APP, Easy Plan and Direct Sales.</p>
				<p><strong>IT/Toss</strong> - Support of TracFone Operations System Support. Assists Representatives who have customer's on the line with system issues.</p>
				<p><strong>Loss Prevention</strong> - Responsible for the investigation of the fraudulent activities against TracFone.</p>
				<p><strong>Ops Research & Reporting</strong> - Research operational issues from the care centers to identify root cause and /or coordinate with the department whose area of expertise is needed to reach a resolution.</p>
				<p><strong>Outbound</strong> - Responsible for calls to the customers for differrent TracFone Campaigns i.e.: Welcome, Drop in Usage, TDMA Migration, Non Redeemer, etc.</p>
				<p><strong>Phone Upgrade</strong> - Responsible for ensuring that each customer is successfully able to upgrade their service from one phone to another.</p>
				<p><strong>Portability</strong> - Responsible for transferring customer's number from an existing carrier to a new carrier.</p>
				<p><strong>Process & Systems</strong> - Responsible for simplifying, enhancing and/ or fixing processes and systems, scripting in Web, Web CSR and IVR, as well as development of Training materials and Training Flashes.</p>
				<p><strong>Product Support</strong> - Responsible for Data Services and International Long Distance.</p>
				<p><strong>Quality</strong> - Responsible for providing independent evaluations of customer interactions with Care Center Representatives to ensure compliance with communicated processes and training standards.</p>
				<p><strong>Retailer Support</strong> - Responsible for providing support to all major retailers, who sell TracFone/NET10 products.</p>
				<p><strong>SafeLink Wireless</strong> - SafeLink Wireless is a government-supported program that provides a free cell phone, and 68 free minutes of airtime each month (free minutes will vary, based on the state and zip code in which the customer resides), to customer's who qualify based on income.</p>
				<p><strong>Straight Talk</strong> - Responsible for all transactions pertinent to the Straight Talk program which offers local, long distance, and data features for one low monthly rate of $29.99</p>
				<p><strong>Training</strong> - Responsible for Care Center Training, Agent Support, Ticker updates and communication.</p>
				<p><strong>Warranty Service</strong> - Responsible for Warranty, Technology Exchange Cases for handsets, SIM cards, and accessories.</p>
				<p><strong>Workforce</strong> - Bridges the offshore Care Centers with Miami Ops and determines call volumes and schedules aux availability.</p>	
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
		  </div>
		</div>
	  </div>
	</div>
</div>
 