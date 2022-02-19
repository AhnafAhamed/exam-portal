<!-- Template javascript -->
<script src="<?php echo base_url('js/basic.js?q=' . time()); ?>"></script>
<style>
	td {
		font-size: 18px;
		padding: 4px;
	}

	.row {
		margin: 0px;
	}

	#timer {
		font-size: 20px;
		color: red;
	}

	.option_container {
		max-height: 100%;
	}

	.question_conatiner {
		max-height: max-content;

	}

	#color-box {
		display: flex;
		justify-content: space-evenly;
	}

	.box {
		display: block;
		color: white;
		font-size: 12px;
		border-radius: 5px;
		width: 80px;
		padding: 5px 4px;
		text-align: center;
	}
</style>


<script>
	var Timer;
	var TotalSeconds;


	function CreateTimer(TimerID, Time) {
		Timer = document.getElementById(TimerID);
		TotalSeconds = Time;

		UpdateTimer()
		window.setTimeout("Tick()", 1000);
	}

	function Tick() {
		if (TotalSeconds <= 0) {
			alert("Time's up!")
			return;
		}

		TotalSeconds -= 1;
		UpdateTimer()
		window.setTimeout("Tick()", 1000);
	}

	function UpdateTimer() {
		var Seconds = TotalSeconds;

		var Days = Math.floor(Seconds / 86400);
		Seconds -= Days * 86400;

		var Hours = Math.floor(Seconds / 3600);
		Seconds -= Hours * (3600);

		var Minutes = Math.floor(Seconds / 60);
		Seconds -= Minutes * (60);


		var TimeStr = ((Days > 0) ? Days + " days " : "") + LeadingZero(Hours) + ":" + LeadingZero(Minutes) + ":" + LeadingZero(Seconds)


		Timer.innerHTML = TimeStr;
	}


	function LeadingZero(Time) {

		return (Time < 10) ? "0" + Time : +Time;

	}

	//var myCountdown1 = new Countdown({time:<?php echo $seconds; ?>, rangeHi:"hour", rangeLo:"second"});
	setTimeout(submitform, '<?php echo $seconds * 1000; ?>');

	function submitform() {
		alert('Time Over');
		window.location = "<?php echo site_url('quiz/submit_quiz/'); ?>";
	}
</script>



<div class=" ">



	<div style="background:#0c179a;padding:16px;color:#ffffff; text-align:center;">
		<!-- <div class="save_answer_signal" id="save_answer_signal2"></div>
		<div class="save_answer_signal" id="save_answer_signal1"></div> -->
		<div>
			<h5><?php echo $title; ?></h5>
		</div>

		<div style="margin-bottom: 8px;">
			<i class="fas fa-fw fa-clock" style="font-size: 20px; "></i>
		</div>

		<div>

			<span id='timer'>
				<script type="text/javascript">
					window.onload = CreateTimer("timer", <?php echo $seconds; ?>);
				</script>
			</span>
		</div>



	</div>







	<div class="row" style="margin-top:0px;">
		<div class="col-md-9">
			<!-- Category button -->

			<div class="row" style="margin:2px; display:none;">
				<?php
				$categories = explode(',', $quiz['categories']);
				$category_range = explode(',', $quiz['category_range']);

				function getfirstqn($cat_keys = '0', $category_range)
				{
					if ($cat_keys == 0) {
						return 0;
					} else {
						$r = 0;
						for ($g = 0; $g < $cat_keys; $g++) {
							$r += $category_range[$g];
						}
						return $r;
					}
				}


				if (count($categories) > 1) {
					$jct = 0;
					foreach ($categories as $cat_key => $category) {
				?>
						<a href="javascript:switch_category('cat_<?php echo $cat_key; ?>');" class="btn btn-info" style="cursor:pointer;margin-left:5px;"><?php echo $category; ?></a>
						<input type="hidden" id="cat_<?php echo $cat_key; ?>" value="<?php echo getfirstqn($cat_key, $category_range); ?>">
				<?php
					}
				}
				?>
			</div>


			<form method="post" action="<?php echo site_url('quiz/submit_quiz/' . $quiz['rid']); ?>" id="quiz_form">
				<input type="hidden" name="rid" value="<?php echo $quiz['rid']; ?>">
				<input type="hidden" name="noq" value="<?php echo $quiz['noq']; ?>">
				<input type="hidden" name="individual_time" id="individual_time" value="<?php echo $quiz['individual_time']; ?>">

				<?php
				$abc = array(
					'0' => 'A',
					'1' => 'B',
					'2' => 'C',
					'3' => 'D',
					'4' => 'E',
					'6' => 'F',
					'7' => 'G',
					'8' => 'H',
					'9' => 'I',
					'10' => 'J',
					'11' => 'K'
				);
				foreach ($questions as $qk => $question) {
				?>

					<div id="q<?php echo $qk; ?>" class="question_div">

						<div class="question_container">

							<?php
							if (strip_tags($question['paragraph']) != "") {
								echo $this->lang->line('paragraph') . "<br>";
								echo $question['paragraph'] . "<hr>";
							}
							?>
							<span style="font-weight: bold; font-size:18px;">
								<?php echo $this->lang->line('question'); ?> <?php echo $qk + 1; ?> -
							</span><br>
							<span style="font-size: 18px;">
								<?php
								echo str_replace('../../../', base_url(), str_replace('../../../../', base_url(), $question['question']));
								?>
							</span>

						</div>
						<div class="option_container">
							<?php
							// multiple single choice
							if ($question['question_type'] == $this->lang->line('multiple_choice_single_answer')) {

								$save_ans = array();
								foreach ($saved_answers as $svk => $saved_answer) {
									if ($question['qid'] == $saved_answer['qid']) {
										$save_ans[] = $saved_answer['q_option'];
									}
								}


							?>
								<input type="hidden" name="question_type[]" id="q_type<?php echo $qk; ?>" value="1">
								<?php
								$i = 0;
								foreach ($options as $ok => $option) {
									if ($option['qid'] == $question['qid']) {
								?>

										<div class="op">




											<table>
												<tr>
													<td>
														<?php
														echo $abc[$i] . ' - ';
														?>



														<input type="radio" name="answer[<?php echo $qk; ?>][]" id="answer_value<?php echo $qk . '-' . $i; ?>" value="<?php echo $option['oid']; ?>" <?php if (in_array($option['oid'], $save_ans)) {
																																																			echo 'checked';
																																																		} ?>>




													</td>
													<td> <?php echo $option['q_option']; ?>
													</td>
												</tr>
											</table>

										</div>



								<?php
										$i += 1;
									} else {
										$i = 0;
									}
								}
							}

							// multiple_choice_multiple_answer	

							if ($question['question_type'] == $this->lang->line('multiple_choice_multiple_answer')) {
								$save_ans = array();
								foreach ($saved_answers as $svk => $saved_answer) {
									if ($question['qid'] == $saved_answer['qid']) {
										$save_ans[] = $saved_answer['q_option'];
									}
								}

								?>
								<input type="hidden" name="question_type[]" id="q_type<?php echo $qk; ?>" value="2">
								<?php
								$i = 0;
								foreach ($options as $ok => $option) {
									if ($option['qid'] == $question['qid']) {
								?>

										<div class="op">
											<table>
												<tr>
													<td>
														<?php echo $abc[$i]; ?>) <input type="checkbox" name="answer[<?php echo $qk; ?>][]" id="answer_value<?php echo $qk . '-' . $i; ?>" value="<?php echo $option['oid']; ?>" <?php if (in_array($option['oid'], $save_ans)) {
																																																										echo 'checked';
																																																									} ?>>
													</td>
													<td>
														<?php echo $option['q_option']; ?>
													</td>
												</tr>
											</table>
										</div>


								<?php
										$i += 1;
									} else {
										$i = 0;
									}
								}
							}

							// short answer	

							if ($question['question_type'] == $this->lang->line('short_answer')) {
								$save_ans = "";
								foreach ($saved_answers as $svk => $saved_answer) {
									if ($question['qid'] == $saved_answer['qid']) {
										$save_ans = $saved_answer['q_option'];
									}
								}
								?>
								<input type="hidden" name="question_type[]" id="q_type<?php echo $qk; ?>" value="3">
								<?php
								?>

								<div class="op">
									<?php echo $this->lang->line('answer'); ?>
									<input type="text" name="answer[<?php echo $qk; ?>][]" value="<?php echo $save_ans; ?>" id="answer_value<?php echo $qk; ?>">
								</div>


							<?php


							}


							// long answer	

							if ($question['question_type'] == $this->lang->line('long_answer')) {
								$save_ans = "";
								foreach ($saved_answers as $svk => $saved_answer) {
									if ($question['qid'] == $saved_answer['qid']) {
										$save_ans = $saved_answer['q_option'];
									}
								}
							?>
								<input type="hidden" name="question_type[]" id="q_type<?php echo $qk; ?>" value="4">
								<?php
								?>

								<div class="op">
									<?php echo $this->lang->line('answer'); ?> <br>
									<?php echo $this->lang->line('word_counts'); ?> <span id="char_count<?php echo $qk; ?>">0</span>
									<textarea name="answer[<?php echo $qk; ?>][]" id="answer_value<?php echo $qk; ?>" style="width:100%;height:100%;" onKeyup="count_char(this.value,'char_count<?php echo $qk; ?>');"><?php echo $save_ans; ?></textarea>
								</div>


							<?php


							}







							// matching	

							if ($question['question_type'] == $this->lang->line('match_the_column')) {
								$save_ans = array();
								foreach ($saved_answers as $svk => $saved_answer) {
									if ($question['qid'] == $saved_answer['qid']) {
										// $exp_match=explode('__',$saved_answer['q_option_match']);
										$save_ans[] = $saved_answer['q_option'];
									}
								}


							?>
								<input type="hidden" name="question_type[]" id="q_type<?php echo $qk; ?>" value="5">
								<?php
								$i = 0;
								$match_1 = array();
								$match_2 = array();
								foreach ($options as $ok => $option) {
									if ($option['qid'] == $question['qid']) {
										$match_1[] = $option['q_option'];
										$match_2[] = $option['q_option_match'];
								?>



								<?php
										$i += 1;
									} else {
										$i = 0;
									}
								}
								?>
								<div class="op">
									<table>

										<?php
										shuffle($match_1);
										shuffle($match_2);
										foreach ($match_1 as $mk1 => $mval) {
										?>
											<tr>
												<td>
													<?php echo $abc[$mk1]; ?>) <?php echo $mval; ?>
												</td>
												<td>

													<select name="answer[<?php echo $qk; ?>][]" id="answer_value<?php echo $qk . '-' . $mk1; ?>">
														<option value="0"><?php echo $this->lang->line('select'); ?></option>
														<?php
														foreach ($match_2 as $mk2 => $mval2) {
														?>
															<option value="<?php echo $mval . '___' . $mval2; ?>" <?php $m1 = $mval . '___' . $mval2;
																													if (in_array($m1, $save_ans)) {
																														echo 'selected';
																													} ?>><?php echo $mval2; ?></option>
														<?php
														}
														?>
													</select>

												</td>
											</tr>


										<?php
										}


										?>
									</table>
								</div>
							<?php

							}

							?>

						</div>
					</div>



				<?php
				}
				?>
			</form>
		</div>
		<div class="col-md-3" style="padding:5px;color:#212121;">

			<b> <?php echo $this->lang->line('questions'); ?></b>
			<div style="max-height:100%;overflow-y:auto;">
				<?php
				for ($j = 0; $j < $quiz['noq']; $j++) {
				?>

					<div class="qbtn" onClick="javascript:show_question('<?php echo $j; ?>');" id="qbtn<?php echo $j; ?>"><?php echo ($j + 1); ?></div>

				<?php
				}
				?>
				<div style="clear:both;"></div>

			</div>


			<br>

			<div id="color-box">
				<span class="box" style="background:#449d44;">Answered</span>
				<!-- <p>Answered</p> -->
				<span class="box" style="background:#c9302c;">Unanswered</span>
				<!-- <p>Unanswered</p> -->
				<span class="box" style="background:#ffe136;">Review Later</span>
				<!-- <p>Review Later</p> -->
				<span class="box" style="background:#212121;">Not Visited</span>
				<!-- <p>Not Visited</p> -->
			</div>



		</div>


	</div>





</div>



<div class="footer_buttons">

	<button class="btn btn-success fbtn" style="background-color: #449d44;" id="nextbtns" onClick="javascript:show_next_question();"><?php echo $this->lang->line('save_next'); ?></button>

	<button class="btn btn-dark fbtn" id="backbtn" style="visibility:hidden;" onClick="javascript:show_back_question();"><?php echo $this->lang->line('back'); ?></button>

	<button class="btn btn-warning fbtn" style="background-color: #ffe136 !important; border:none;" onClick="javascript:review_later();"><?php echo $this->lang->line('review_later'); ?></button>

	<button class="btn btn-info fbtn" onClick="javascript:clear_response();""><?php echo $this->lang->line('clear'); ?></button>



	<button class=" btn btn-danger fbtn" onClick="javascript:cancelmove();"><?php echo $this->lang->line('submit_quiz'); ?></button>
</div>

<script>
	var ctime = 0;
	var ind_time = new Array();
	<?php
	$ind_time = explode(',', $quiz['individual_time']);
	for ($ct = 0; $ct < $quiz['noq']; $ct++) {
	?>
		ind_time[<?php echo $ct; ?>] = <?php if (!isset($ind_time[$ct])) {
											echo 0;
										} else {
											echo $ind_time[$ct];
										} ?>;
	<?php
	}
	?>
	noq = "<?php echo $quiz['noq']; ?>";
	show_question('0');


	function increasectime() {

		ctime += 1;

	}
	setInterval(increasectime, 1000);
	setInterval(setIndividual_time, 30000);
</script>





<div id="warning_div" style="padding:10px; position:fixed;z-index:100;display:none;width:100%;border-radius:5px;height:150px; border:1px solid #dddddd;top:200px;background:#ffffff;">
	<center><b> <?php echo $this->lang->line('really_Want_to_submit'); ?></b> <br><br>
		<span id="processing"></span>

		<a href="javascript:cancelmove();" class="btn btn-danger" style="cursor:pointer;"><?php echo $this->lang->line('cancel'); ?></a> &nbsp; &nbsp; &nbsp; &nbsp;
		<a href="javascript:submit_quiz();" class="btn btn-info" style="cursor:pointer;"><?php echo $this->lang->line('submit_quiz'); ?></a>
	</center>
</div>