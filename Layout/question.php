<style>
  .faq-section {
    color: #f8fafc;
    font-family: "Segoe UI", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    background:
      linear-gradient(120deg, rgba(5, 10, 20, 0.9), rgba(9, 18, 35, 0.82)),
      url("background.webp") center / cover no-repeat;
  }

  .faq-accordion .accordion-item {
    overflow: hidden;
    color: #e2e8f0;
    background: rgba(8, 15, 30, 0.78);
    border: 1px solid rgba(148, 163, 184, 0.24);
    border-radius: 0.75rem;
  }

  .faq-accordion .accordion-button,
  .faq-accordion .accordion-button:not(.collapsed) {
    color: #f8fafc;
    font-weight: 600;
    background: rgba(15, 23, 42, 0.88);
    box-shadow: none;
  }

  .faq-accordion .accordion-button:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
  }

  .faq-accordion .accordion-button::after {
    filter: brightness(0) invert(1);
  }

  .faq-accordion .accordion-body {
    color: #cbd5e1;
    background: rgba(5, 10, 20, 0.72);
    line-height: 1.7;
  }
</style>

<section class="faq-section py-5">
  <div class="container py-3">
    <div class="row g-4 align-items-center">
      <div class="col-md-5 text-center text-md-start">
        <img src="lampu.png" width="88" height="88" class="img-fluid mb-3" alt="Ikon ide">
        <h2 class="display-6 fw-bold mb-2">FAQ</h2>
        <p class="fs-5 text-white-50 mb-0">Pertanyaan yang sering diajukan</p>
      </div>

      <div class="col-md-7">
        <div class="accordion faq-accordion d-grid gap-2" id="faqAccordion">
          <div class="accordion-item">
            <h3 class="accordion-header">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqOne" aria-expanded="true" aria-controls="faqOne">
                Jasa apa saja yang Anda sediakan?
              </button>
            </h3>
            <div id="faqOne" class="accordion-collapse collapse show">
              <div class="accordion-body">
                Kami melayani berbagai kebutuhan editing, <strong>mulai dari</strong> [Video: YouTube, TikTok/Reels, iklan, pernikahan] hingga [Teks/Foto: naskah, jurnal, manipulasi foto, katalog produk].
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h3 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqTwo" aria-expanded="false" aria-controls="faqTwo">
                Software apa saja yang tim Anda gunakan?
              </button>
            </h3>
            <div id="faqTwo" class="accordion-collapse collapse">
              <div class="accordion-body">
                Kami menggunakan software standar industri profesional seperti [Adobe Premiere Pro, After Effects, Photoshop, DaVinci Resolve, atau CapCut Pro] untuk memastikan hasil akhir berkualitas tinggi.
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h3 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqThree" aria-expanded="false" aria-controls="faqThree">
                Bagaimana sistem penentuan harganya?
              </button>
            </h3>
            <div id="faqThree" class="accordion-collapse collapse">
              <div class="accordion-body">
                Harga dihitung berdasarkan [misal: durasi video mentah/jadi, tingkat kerumitan efek, atau per halaman untuk teks]. Hubungi kami untuk mendapatkan estimasi harga terbaik.
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h3 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqFour" aria-expanded="false" aria-controls="faqFour">
                Bagaimana cara mengirimkan file mentah berukuran besar?
              </button>
            </h3>
            <div id="faqFour" class="accordion-collapse collapse">
              <div class="accordion-body">
                Anda cukup mengunggah (upload) file mentah ke Google Drive, Dropbox, atau WeTransfer, lalu bagikan tautannya (link) kepada kami dengan akses terbuka.
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h3 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqFive" aria-expanded="false" aria-controls="faqFive">
                Bagaimana sistem pembayarannya?
              </button>
            </h3>
            <div id="faqFive" class="accordion-collapse collapse">
              <div class="accordion-body">
                • Kami memberlakukan sistem DP (Uang Muka) sebesar [misal: 50%] sebelum editing dimulai, dan pelunasan dilakukan setelah hasil edit final disetujui (diberi watermark terlebih dahulu sebelum lunas).
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
