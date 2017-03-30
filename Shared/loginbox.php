		<!-- Overlay -->

  <div id="overlay" style="display:none"></div>
  
	<!-- Login Box Start! -->

  <div id='loginBox' class="loginBox" style="display:none">
		<div id='login'>
			<div class='loginBoxheader'>
				<h3>Login</h3>
				<div onclick="closeWindows()">x</div>
			</div>
			  <div class="table-wrap">
				<table>
					<tr>
						<td>
							<label class="text">Login name:</label>
						</td>
					</tr>
					<tr>
						<td>

							<input id="username" placeholder="Username" class='form-control textinput' type='text' autofocus >
						</td>
					</tr>
					<tr>
						<td>
							<label class="text">Password:</label>
						</td>
					</tr>
					<tr>
						<td>
							<input id="password" placeholder="Password" class='form-control textinput' type='password' >
						</td>
					</tr>
					<tr>
						<td>
							<input id='saveuserlogin' type='checkbox' value="on">
							<label class="text">Remember me</label>
						</td>
					</tr>
					<tr>
						<td id="message"></td>
					</tr>
					<tr>
						<td>

							<input type='button' class='submit-button' onclick="processLogin();" value='Login'>
						
							<label class='forgotPw' onclick='toggleloginnewpass();'>Forgot password?</label>

						</td>
					</tr>
				</table>
			  </div>
		</div>
		<div id='newpassword' style="display:none">
			<div class='loginBoxheader' id="passwordid">
				<h3>New Password</h3>
				<div onclick="closeWindows()">x</div>
			</div>
			  <div class="table-wrap">
				<table>
					<tr>
						<td>
							<label class="text">username:</label>
						</td>
					</tr>
					<tr>
						<td>
							<input id="username" class='form-control textinput' type='text' placeholder="c13andfi" autofocus >
						</td>
					</tr>
	
					<tr>
						<td id="message2"></td>
					</tr>
					<tr>
						<td>
							<input type='button' class='submit-button' onclick="processResetPasswordCheckUsername();" value='Check user'>
							<label class='forgotPw' onclick='toggleloginnewpass();'>Log in</label>
						</td>
					</tr>
				</table>
			  </div>
		</div>
		<div id='showsecurityquestion' style="display:none">
			<div class='loginBoxheader' id="securityid"><!--What is this id?-->
				<h3>New Password</h3>
				<div onclick="closeWindows()">x</div>
			</div>
			  <div class="table-wrap">
				<table>
					<tr>
						<td>
							<label class="text">Your sequrity queston is:</label>
						</td>
						<td>
							<label class="text">Who let the dogs out? BTW: maybe not the perfect solution to use a label for the question</label>
						</td>
					</tr>
					<tr>
						<td>
							<input id="answer" class='form-control textinput' type='password' placeholder="Answer" autofocus >
						</td>
					</tr>
	
					<tr>
						<td id="message3"></td>
					</tr>
					<tr>
						<td>
							<input type='button' class='submit-button' onclick="processResetPasswordCheckSecurityAnswer();" value='Check answer'>
							<label class='forgotPw' onclick='toggleloginnewpass();'>Abort</label>
						</td>
					</tr>
				</table>
			  </div>
		</div>
		<div id='changepassword' style="display:none">
			<div class='loginBoxheader' id="changeid"><!--What is this id?-->
				<h3>New Password</h3>
				<div onclick="closeWindows()">x</div>
			</div>
			  <div class="table-wrap">
				<table>
					<tr>
						<td>
							<label class="text">New password:</label>
						</td>
					</tr>
					<tr>
						<td>

							<input id="newpassword" placeholder="New password" class='form-control textinput' type='password' autofocus >
						</td>
					</tr>
					<tr>
						<td>
							<label class="text">Confirm new password:</label>
						</td>
					</tr>
					<tr>
						<td>
							<input id="confirmpassword" placeholder="Confirm password" class='form-control textinput' type='password' >
						</td>
					</tr>
					<tr>
						<td id="message4"></td>
					</tr>
					<tr>
						<td>
							<input type='button' class='submit-button' onclick="processResetPasswordChangePassword();" value='Change password'>
							<label class='forgotPw' onclick='toggleloginnewpass();'>Abort</label>
						</td>
					</tr>
				</table>
			  </div>
		</div>
	</div>
	</div>
	
	
	<!-- Login Box End! -->
