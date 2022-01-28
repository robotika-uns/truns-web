<template>
  <div>
    <div class="py-96 -mt-10 md:-mt-1 md:py-28"></div>

    <div id="footers" class="shadow-xl shadow-black bg-black/50">
      <footer class="p-10 footer text-base-content">
        <div>
          <img src="/assets/img/logo.png" width="70" height="70" alt="" />

          <p>
            <b>UKM Robotika UNS</b><br />Jl. Ir. Sutami N0-36 Kentingan,
            <br />Jebres, Surakarta, 57126, Indonesia.
          </p>
        </div>
        <div>
          <span class="footer-title">Menu</span>
          <NuxtLink to="/" class="link link-hover">Lab</NuxtLink>
          <NuxtLink to="/tim" class="link link-hover">Tim</NuxtLink>
          <NuxtLink to="/divisi" class="link link-hover">Divisi</NuxtLink>
          <NuxtLink to="/kontak" class="link link-hover">Kontak</NuxtLink>
        </div>
        <div>
          <span class="footer-title">Anggota</span>
          <NuxtLink to="/pendaftaran" class="link link-hover"
            >Pendaftaran</NuxtLink
          >
          <NuxtLink to="/struktur" class="link link-hover">Struktur</NuxtLink>
          <NuxtLink to="/alumni" class="link link-hover">Alumni</NuxtLink>
          <NuxtLink to="/galeri" class="link link-hover">Galeri</NuxtLink>
        </div>
        <div>
          <span class="footer-title">Sosial Media</span>
          <a
            href="https://www.instagram.com/robotika.uns/"
            target="_blank"
            class="link link-hover"
          >
            <div class="flex">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
              >
                <path fill="none" d="M0 0h24v24H0z" />
                <path
                  d="M12 2c2.717 0 3.056.01 4.122.06 1.065.05 1.79.217 2.428.465.66.254 1.216.598 1.772 1.153a4.908 4.908 0 0 1 1.153 1.772c.247.637.415 1.363.465 2.428.047 1.066.06 1.405.06 4.122 0 2.717-.01 3.056-.06 4.122-.05 1.065-.218 1.79-.465 2.428a4.883 4.883 0 0 1-1.153 1.772 4.915 4.915 0 0 1-1.772 1.153c-.637.247-1.363.415-2.428.465-1.066.047-1.405.06-4.122.06-2.717 0-3.056-.01-4.122-.06-1.065-.05-1.79-.218-2.428-.465a4.89 4.89 0 0 1-1.772-1.153 4.904 4.904 0 0 1-1.153-1.772c-.248-.637-.415-1.363-.465-2.428C2.013 15.056 2 14.717 2 12c0-2.717.01-3.056.06-4.122.05-1.066.217-1.79.465-2.428a4.88 4.88 0 0 1 1.153-1.772A4.897 4.897 0 0 1 5.45 2.525c.638-.248 1.362-.415 2.428-.465C8.944 2.013 9.283 2 12 2zm0 5a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm6.5-.25a1.25 1.25 0 0 0-2.5 0 1.25 1.25 0 0 0 2.5 0zM12 9a3 3 0 1 1 0 6 3 3 0 0 1 0-6z"
                  class="fill-primary"
                />
              </svg>
              <span class="my-auto ml-2"> Instagram </span>
            </div>
          </a>

          <a
            href="https://www.youtube.com/channel/UCu0KltQUPiiQaDvggLl-lXA"
            target="_blank"
            class="link link-hover"
          >
            <div class="flex">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
              >
                <path fill="none" d="M0 0h24v24H0z" />
                <path
                  d="M21.543 6.498C22 8.28 22 12 22 12s0 3.72-.457 5.502c-.254.985-.997 1.76-1.938 2.022C17.896 20 12 20 12 20s-5.893 0-7.605-.476c-.945-.266-1.687-1.04-1.938-2.022C2 15.72 2 12 2 12s0-3.72.457-5.502c.254-.985.997-1.76 1.938-2.022C6.107 4 12 4 12 4s5.896 0 7.605.476c.945.266 1.687 1.04 1.938 2.022zM10 15.5l6-3.5-6-3.5v7z"
                  class="fill-primary"
                />
              </svg>
              <span class="my-auto ml-2"> Youtube </span>
            </div>
          </a>
        </div>
      </footer>
    </div>
  </div>
</template>

<script>
export default {
  name: 'FooterComponent',
}
</script>