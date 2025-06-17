@extends('layouts.main')

@section('style')
<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: "Inter", sans-serif;
    color: #1f2937;
  }

  .font-headland {
    font-family: "Headland One", serif;
  }
  .bg-blue-900 {
    background-color: #043870 !important;
  }
  .text-blue-900 {
    color: #043870 !important;
  }
  .hover-blue:hover {
    color: #1e40af !important;
  }

  .guideline-step {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
  }

  .bg-pink {
    background-color: #ec4899 !important;
  }

  @media (max-width: 999px) {
    .wave-top,
    .wave-bottom {
      display: none !important;
    }

    .smart {
      color: #043870;
    }
  }
</style>
@endsection

@section('content')
    <!-- Hero Section -->
    <div class="position-relative overflow-hidden">
      <img src="{{ asset('assets/img/background/pesawat.png') }}" alt="Airport" class="w-100 object-fit-cover" style="aspect-ratio: 16 / 9" />
    </div>

    <!-- Hero Tagline and Smaller Wave -->
    <div class="position-relative" style="margin-top: -80px; height: 200px">
      \
      <!-- Tagline -->
      <div class="position-absolute top-50 start-50 translate-middle text-white text-center" style="z-index: 30">
        <h1 class="smart fs-4 fs-md-3 fw-semibold">Smart, Integrated, Key to Productivity!</h1>
      </div>

      <!-- Smaller Wave Top -->
      <div class="wave-top position-absolute top-0 w-100" style="z-index: 20">
        <svg viewBox="0 0 1440 150" class="w-100" preserveAspectRatio="none">
          <path d="M0 0C0 0 436 35 720 35C1004 35 1440 0 1440 0V150H0V0Z" fill="#043870" />
        </svg>
      </div>

      <!-- Smaller Wave Bottom -->
      <div class="wave-bottom position-absolute bottom-0 w-100" style="z-index: 20">
        <svg viewBox="0 0 1440 150" class="w-100" preserveAspectRatio="none" style="transform: rotate(180deg)">
          <path d="M0 0C0 0 436 35 720 35C1004 35 1440 0 1440 0V150H0V0Z" fill="#043870" />
        </svg>
      </div>
    </div>

    <!-- Work Permit Section -->
    <div class="container py-5">
      <div class="row align-items-center">
        <div class="col-md-6 mb-4 mb-md-0">
          <h2 class="text-blue-900 fw-bold mb-3">Work Permit Letter</h2>
          <p class="fs-5 text-blue-900">
            The Work Permit Letter system (SIK) is a web-based application designed to handle the process of submitting, verifying, approving, and issuing SIK digitally. This system aims to improve efficiency in the management of work
            permits, reducing administrative errors.
          </p>
        </div>
        <div class="col-md-6 text-center">
          <img src="{{ asset('assets/img/background/komputer.png') }}" class="img-fluid rounded shadow" alt="Laptop and Discussion" />
        </div>
      </div>
    </div>

    <!-- Guidelines Section -->
    <section class="container py-5">
      <h2 class="text-center fw-bold mb-5" style="color: #043870; font-family: 'Inter', sans-serif">GUIDELINES FOR CREATING SIK</h2>

      <!-- Background with Overlay -->
      <div class="position-relative rounded-4 overflow-hidden">
        <img src="{{ asset('assets/img/background/6.png') }}" class="position-absolute w-100 h-100 object-fit-cover" alt="Background" style="object-fit: cover" />
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background-color: rgba(4, 56, 112, 0.85)"></div>

        <!-- Guideline Steps Content -->
        <div class="position-relative text-white py-5 px-4">
          <div class="row row-cols-1 row-cols-md-5 g-4 text-center">
            <div class="col h-100 d-flex flex-column align-items-center text-center guideline-step">
              <img src="{{ asset('assets/img/logo/1.png') }}" class="mb-3" style="height: 48px" alt="Step 1" />
              <p class="fw-bold mb-2">Submissions by External Parties</p>
              <div class="mx-auto my-2" style="width: 160px; height: 2px; background-color: white"></div>
              <p class="small opacity-75">External party (contractor/vendor) fill out the SIK application form</p>
            </div>
            <div class="col h-100 d-flex flex-column align-items-center text-center guideline-step">
              <img src="{{ asset('assets/img/logo/2.png') }}" class="mb-3" style="height: 48px" alt="Step 2" />
              <p class="fw-bold mb-2">Verification of Documents</p>
              <div class="mx-auto my-2" style="width: 160px; height: 2px; background-color: white"></div>
              <p class="small opacity-75">The Director of Operations receives and checks the completeness of the submitted data</p>
            </div>
            <div class="col h-100 d-flex flex-column align-items-center text-center guideline-step">
              <img src="{{ asset('assets/img/logo/3.png') }}" class="mb-3" style="height: 48px" alt="Step 3" />
              <p class="fw-bold mb-2">Approval by Internal Officials</p>
              <div class="mx-auto my-2" style="width: 160px; height: 2px; background-color: white"></div>
              <p class="small opacity-75">The Senior Manager and Vice President will review and approve the SIK application.</p>
            </div>
            <div class="col h-100 d-flex flex-column align-items-center text-center guideline-step">
              <img src="{{ asset('assets/img/logo/4.png') }}" class="mb-4" style="height: 48px" alt="Step 4" />
              <p class="fw-bold mb-4">Issuance of Work Permit</p>
              <div class="mx-auto my-2" style="width: 160px; height: 2px; background-color: white"></div>
              <p class="small opacity-75">After obtaining approval from the Senior Manager and Vice President, the SIK will be issued based on the approved data</p>
            </div>
            <div class="col h-100 d-flex flex-column align-items-center text-center guideline-step">
              <img src="{{ asset('assets/img/logo/5.png') }}" class="mb-4" style="height: 48px" alt="Step 5" />
              <p class="fw-bold mb-4">Monitoring by AVSEC</p>
              <div class="mx-auto my-2" style="width: 160px; height: 2px; background-color: white"></div>
              <p class="small opacity-75">AVSec can view a list of active jobs in progress through the app when patrolling the work area</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Testimonial Section -->
    <div class="bg-white py-5">
      <div class="container d-flex flex-column flex-lg-row justify-content-between align-items-center gap-4">
        <div class="mb-4 mb-lg-0 pe-lg-5">
          <h3 class="fw-bold text-dark mb-3">Look What Our Customers<br />Say About Our Services!</h3>
          <div class="text-center">
            <a href="#" class="btn btn-lg text-white" style="background-color: #0a3d75">Get Started</a>
          </div>
        </div>
        <div class="position-relative" style="max-width: 600px">
          <!-- Left Arrow -->
          <button class="btn btn-primary rounded-circle position-absolute top-50 start-0 translate-middle-y" style="background-color: #043870; z-index: 2">
            <span class="fw-bold">&lt;</span>
          </button>

          <!-- Testimonial Card -->
          <div class="card border-0 shadow rounded-4 px-4 py-4 mx-5" style="background-color: #f9f9f9">
            <div class="fs-1 text-black mb-2">“</div>
            <p class="text-dark mb-3">This website for making a Work Permit (SIK) is very helpful with a clear, fast, and transparent process. The application flow is well-structured, making it easy for users to apply for permissions.</p>
            <hr />
            <div class="d-flex align-items-center">
              <div class="rounded-circle bg-pink text-white d-flex justify-content-center align-items-center me-2" style="width: 36px; height: 36px; font-weight: 600">K</div>
              <span class="fw-medium">Kek Pisang Villa</span>
            </div>
          </div>

          <!-- Right Arrow -->
          <button class="btn btn-primary rounded-circle position-absolute top-50 end-0 translate-middle-y" style="background-color: #043870; z-index: 2">
            <span class="fw-bold">&gt;</span>
          </button>
        </div>
      </div>
    </div>
@endsection