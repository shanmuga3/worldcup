@extends('app')
@section('main')
<main>
	<section id="hero" class="hero hero-home">
		<div class="container position-relative">
			<div class="row gy-5" data-aos="fade-in">
				<div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center text-center text-lg-start">
					<h2> @lang('messages.welcome_to') <span> {{ $site_name }} </span></h2>
					<p class="text-white"> @lang('messages.welcome_desc') </p>
					<div class="d-flex justify-content-center justify-content-lg-start my-3">
						<a href="{{ route('dashboard') }}" class="btn btn-get-started bg-primary fw-bold"> @lang('messages.get_started') </a>
					</div>
				</div>
				<div class="col-lg-6 order-1 order-lg-2">
					<img src="{{ asset('images/hero-img.png') }}" class="img-fluid" alt="" data-aos="zoom-out" data-aos-delay="100">
				</div>
			</div>
		</div>
		{{--
		<div class="icon-boxes position-relative">
			<div class="container position-relative">
				<div class="row gy-4 mt-5">
					<div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
						<div class="icon-box">
							<div class="icon"><i class="bi bi-easel"></i></div>
							<h4 class="title"><a href="" class="stretched-link">LIVE PREDICTION</a></h4>
						</div>
					</div>
					<div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
						<div class="icon-box">
							<div class="icon"><i class="bi bi-gem"></i></div>
							<h4 class="title"><a href="" class="stretched-link">CLEAN USABILITY</a></h4>
						</div>
					</div>
					<div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
						<div class="icon-box">
							<div class="icon"><i class="bi bi-shield"></i></div>
							<h4 class="title"><a href="" class="stretched-link">HIGH SECURITY</a></h4>
						</div>
					</div>
					<div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="500">
						<div class="icon-box">
							<div class="icon"><i class="bi bi-gift"></i></div>
							<h4 class="title"><a href="" class="stretched-link">DAILY PROMOTIONS</a></h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		--}}
	</section>
	{{--
	<section id="faq" class="faq">
		<div class="container" data-aos="fade-up">
			<div class="row gy-4">
				<div class="col-lg-4">
					<div class="content px-xl-5">
						<h3>Frequently Asked <strong>Questions</strong></h3>
						<p>
							Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Duis aute irure dolor in reprehenderit
						</p>
					</div>
				</div>
				<div class="col-lg-8">
					<div class="accordion accordion-flush" id="faqlist" data-aos="fade-up" data-aos-delay="100">
						<div class="accordion-item">
							<h3 class="accordion-header">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-1">
									<span class="num">1.</span>
									Non consectetur a erat nam at lectus urna duis?
								</button>
							</h3>
							<div id="faq-content-1" class="accordion-collapse collapse" data-bs-parent="#faqlist">
								<div class="accordion-body">
									Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus laoreet non curabitur gravida. Venenatis lectus magna fringilla urna porttitor rhoncus dolor purus non.
								</div>
							</div>
						</div>
						<div class="accordion-item">
							<h3 class="accordion-header">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-2">
									<span class="num">2.</span>
									Feugiat scelerisque varius morbi enim nunc faucibus a pellentesque?
								</button>
							</h3>
							<div id="faq-content-2" class="accordion-collapse collapse" data-bs-parent="#faqlist">
								<div class="accordion-body">
									Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.
								</div>
							</div>
						</div>
						<div class="accordion-item">
							<h3 class="accordion-header">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-3">
									<span class="num">3.</span>
									Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi?
								</button>
							</h3>
							<div id="faq-content-3" class="accordion-collapse collapse" data-bs-parent="#faqlist">
								<div class="accordion-body">
									Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Faucibus pulvinar elementum integer enim. Sem nulla pharetra diam sit amet nisl suscipit. Rutrum tellus pellentesque eu tincidunt. Lectus urna duis convallis convallis tellus. Urna molestie at elementum eu facilisis sed odio morbi quis
								</div>
							</div>
						</div>
						<div class="accordion-item">
							<h3 class="accordion-header">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-4">
									<span class="num">4.</span>
									Ac odio tempor orci dapibus. Aliquam eleifend mi in nulla?
								</button>
							</h3>
							<div id="faq-content-4" class="accordion-collapse collapse" data-bs-parent="#faqlist">
								<div class="accordion-body">
									Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.
								</div>
							</div>
						</div>
						<div class="accordion-item">
							<h3 class="accordion-header">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-5">
									<span class="num">5.</span>
									Tempus quam pellentesque nec nam aliquam sem et tortor consequat?
								</button>
							</h3>
							<div id="faq-content-5" class="accordion-collapse collapse" data-bs-parent="#faqlist">
								<div class="accordion-body">
									Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim suspendisse in est ante in. Nunc vel risus commodo viverra maecenas accumsan. Sit amet nisl suscipit adipiscing bibendum est. Purus gravida quis blandit turpis cursus in
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section id="contact" class="contact">
		<div class="container" data-aos="fade-up">
			<div class="section-header">
				<h2>Contact</h2>
				<p>Nulla dolorum nulla nesciunt rerum facere sed ut inventore quam porro nihil id ratione ea sunt quis dolorem dolore earum</p>
			</div>
			<div class="row gx-lg-0 gy-4">
				<div class="col-lg-4">
					<div class="info-container d-flex flex-column align-items-center justify-content-center">
						<div class="info-item d-flex">
							<i class="bi bi-geo-alt flex-shrink-0"></i>
							<div>
								<h4>Location:</h4>
								<p>A108 Adam Street, New York, NY 535022</p>
							</div>
						</div><!-- End Info Item -->
						<div class="info-item d-flex">
							<i class="bi bi-envelope flex-shrink-0"></i>
							<div>
								<h4>Email:</h4>
								<p>info@example.com</p>
							</div>
						</div><!-- End Info Item -->
						<div class="info-item d-flex">
							<i class="bi bi-phone flex-shrink-0"></i>
							<div>
								<h4>Call:</h4>
								<p>+1 5589 55488 55</p>
							</div>
						</div><!-- End Info Item -->
						<div class="info-item d-flex">
							<i class="bi bi-clock flex-shrink-0"></i>
							<div>
								<h4>Open Hours:</h4>
								<p>Mon-Sat: 11AM - 23PM</p>
							</div>
						</div><!-- End Info Item -->
					</div>
				</div>
				<div class="col-lg-8">
					<form action="forms/contact.php" method="post" role="form" class="php-email-form">
						<div class="row">
							<div class="col-md-6 form-group">
								<input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
							</div>
							<div class="col-md-6 form-group mt-3 mt-md-0">
								<input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
							</div>
						</div>
						<div class="form-group mt-3">
							<input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
						</div>
						<div class="form-group mt-3">
							<textarea class="form-control" name="message" rows="7" placeholder="Message" required></textarea>
						</div>
						<div class="my-3">
							<div class="loading">Loading</div>
							<div class="error-message"></div>
							<div class="sent-message">Your message has been sent. Thank you!</div>
						</div>
						<div class="text-center"><button type="submit">Send Message</button></div>
					</form>
				</div>
			</div>
		</div>
	</section>
	--}}
</main>
@endsection