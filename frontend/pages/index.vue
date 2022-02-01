<template>
  <div>
    <Navbar />

    <div class="hero min-h-screen mt-[-9rem]">
      <video
        id="myVideo"
        autoplay
        muted
        loop
        class="opacity-10"
        style="object-fit: cover; width: 100vw; height: 100vh; top: 0; left: 0"
      >
        <source
          src="https://drive.google.com/uc?export=download&id=1NnrQu3lzfoHonl11juinRLeg8XEGbwQE"
          type="video/mp4"
        />
      </video>
      <div
        class="
          flex-col
          justify-center
          hero-content
          lg:flex-row-reverse
          min-w-full
          px-5
          md:px-14
          z-10
          pt-24
        "
      >
        <img src="/assets/img/logo.png" class="p-16 md:max-w-lg" />
        <div class="w-full md:pl-10 text-center md:text-left">
          <h1 class="mb-5 text-5xl font-bold tracking-wide text-slate-100">
            <span class="font-light">UKM</span> ROBOTIKA UNS
          </h1>
          <p class="mb-5 lg:pr-32 text-white/60 tracking-wide text-2xl">
            Unit Kegiatan Mahasiswa, Pusat Pengembangan, dan Riset Bidang
            Robotika
            <b>Universitas Sebelas Maret</b>, Surakarta, Indonesia.
          </p>
          <NuxtLink to="/rekrutmen" class="btn btn-primary tracking-wider"
            >Rekrutmen &nbsp;
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 24 24"
              width="24"
              height="24"
            >
              <path fill="none" d="M0 0h24v24H0z" />
              <path
                d="M12 11a5 5 0 0 1 5 5v6H7v-6a5 5 0 0 1 5-5zm-6.712 3.006a6.983 6.983 0 0 0-.28 1.65L5 16v6H2v-4.5a3.5 3.5 0 0 1 3.119-3.48l.17-.014zm13.424 0A3.501 3.501 0 0 1 22 17.5V22h-3v-6c0-.693-.1-1.362-.288-1.994zM5.5 8a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5zm13 0a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5zM12 2a4 4 0 1 1 0 8 4 4 0 0 1 0-8z"
              />
            </svg>
          </NuxtLink>
        </div>
      </div>
      <Wave />
    </div>

    <h1
      class="
        pt-24
        text-5xl
        font-light
        tracking-widest
        text-center
        bg-base-300
        text-slate-100
      "
    >
      TIM
    </h1>

    <div id="tim" class="anchor"></div>

    <div
      class="
        grid
        lg:grid-cols-2
        xl:grid-cols-3
        gap-16
        p-5
        pb-64
        md:pb-64 md:p-24
        mx-auto
        bg-base-300
      "
    >
      <div
        v-for="tim in tims"
        :key="tim.nama"
        class="card bg-base-100 shadow-xl shadow-black/50 relative z-10"
      >
        <div class="flex bg-base-300/50 p-5">
          <img :src="tim.logo" class="w-28 pr-3" />
          <div class="card-title my-auto">
            <div class="font-light text-lg tracking-widest">
              {{ tim.divisi }}
            </div>
            <span class="uppercase tracking-widest text-3xl">
              {{ tim.nama }}
            </span>
          </div>
        </div>
        <div class="card-body">
          <p>
            {{ tim.penjelasan }}
          </p>

          <div class="bg-base-300 p-6 rounded-lg mt-7">
            <div
              class="mb-6 rounded-md text-center"
              :style="`background-color: ${tim.warna.bg}; color: ${tim.warna.text}; `"
            >
              <span class="font-bold uppercase text-lg">
                Tingkat Kompleksitas
              </span>
            </div>

            <!-- /* ------------------------- Programmer ------------------------ */ -->
            <div class="flex">
              <div data-tip="Programmer" class="tooltip">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  width="24"
                  height="24"
                  class="my-auto"
                >
                  <path fill="none" d="M0 0h24v24H0z" />
                  <path
                    d="M3 3h18a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zm9 12v2h6v-2h-6zm-3.586-3l-2.828 2.828L7 16.243 11.243 12 7 7.757 5.586 9.172 8.414 12z"
                    class="fill-primary"
                  />
                </svg>
              </div>

              <div
                :data-tip="`${tim.kompleksitas.programmer}%`"
                class="tooltip w-full ml-3"
              >
                <progress
                  class="progress progress-primary bg-base-100 my-auto"
                  :value="tim.kompleksitas.programmer"
                  max="100"
                ></progress>
              </div>
            </div>
            <!-- /* -------------------------------------------------------------- */ -->

            <!-- /* --------------------------- Elektro -------------------------- */ -->
            <div class="flex mt-3">
              <div data-tip="Elektro" class="tooltip">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  width="24"
                  height="24"
                >
                  <path fill="none" d="M0 0h24v24H0z" />
                  <path d="M13 10h7l-9 13v-9H4l9-13z" class="fill-primary" />
                </svg>
              </div>

              <div
                :data-tip="`${tim.kompleksitas.elektro}%`"
                class="tooltip w-full ml-3"
              >
                <progress
                  class="progress progress-primary bg-base-100 my-auto"
                  :value="tim.kompleksitas.elektro"
                  max="100"
                ></progress>
              </div>
            </div>
            <!-- /* ---------------------------------------------------------------- */ -->

            <!-- /* --------------------------- Mekanik -------------------------- */ -->
            <div class="flex mt-3">
              <div data-tip="Mekanik" class="tooltip">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  width="24"
                  height="24"
                >
                  <path fill="none" d="M0 0h24v24H0z" />
                  <path
                    d="M17 8V2h3a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1h-3zm-2 14a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1V8H2.5V6.074a1 1 0 0 1 .496-.863L8.5 2H15v20z"
                    class="fill-primary"
                  />
                </svg>
              </div>

              <div
                :data-tip="`${tim.kompleksitas.mekanik}%`"
                class="tooltip w-full ml-3"
              >
                <progress
                  class="progress progress-primary bg-base-100 my-auto"
                  :value="tim.kompleksitas.mekanik"
                  max="100"
                ></progress>
              </div>
            </div>
            <!-- /* ---------------------------------------------------------------- */ -->
          </div>

          <div class="justify-end card-actions">
            <NuxtLink
              :to="tim.url"
              class="
                btn
                border-none
                hover:shadow-lg hover:-translate-y-2 hover:shadow-white/50
                tracking-widest
              "
              :style="`background-color: ${tim.warna.bg}; color: ${tim.warna.text};`"
            >
              Informasi Tim
            </NuxtLink>
          </div>
        </div>
      </div>
    </div>

    <Wave3 />
    <h1
      class="
        text-5xl
        font-light
        tracking-widest
        text-center
        bg-base-100
        text-slate-100
      "
    >
      DIVISI
    </h1>

    <div id="divisi" class="anchor"></div>

    <div
      class="
        grid
        xl:grid-cols-3
        gap-16
        p-5
        pb-0
        md:p-24 md:pb-0
        mx-auto
        bg-base-100
      "
    >
      <div
        v-for="teknis in divisis.teknis"
        :key="teknis.nama"
        class="card bg-base-100 shadow-xl shadow-black/50"
      >
        <div class="flex bg-base-300/50 p-5">
          <img :src="teknis.logo" class="w-24 pr-4" />
          <div class="card-title my-auto">
            <div class="font-light text-lg tracking-widest">Divisi Teknis</div>
            <span class="uppercase tracking-widest text-3xl">
              {{ teknis.nama }}
            </span>
          </div>
        </div>
        <div class="card-body relative">
          <p class="pb-24">
            {{ teknis.penjelasan }}
          </p>
          <NuxtLink
            :to="teknis.url"
            class="
              btn btn-primary
              hover:shadow-lg
              tracking-widest
              hover:shadow-white/50
              absolute
              bottom-8
              right-8
              left-8
            "
          >
            Informasi Divisi
          </NuxtLink>
        </div>
      </div>
    </div>

    <div
      class="
        grid
        lg:grid-cols-2
        xl:grid-cols-4
        gap-10
        p-5
        pb-24
        md:p-24
        mx-auto
        bg-base-100
      "
    >
      <div
        v-for="nonteknis in divisis.nonteknis"
        :key="nonteknis.nama"
        class="card bg-base-100 shadow-xl shadow-black/50"
      >
        <div class="flex bg-base-300/50 p-5">
          <img :src="nonteknis.logo" class="w-24 pr-4" />
          <div class="card-title my-auto">
            <div class="font-light text-lg tracking-widest">
              Divisi Non-Teknis
            </div>
            <span class="uppercase tracking-widest text-2xl">
              {{ nonteknis.nama }}
            </span>
          </div>
        </div>
        <div class="card-body">
          <p class="pb-24">
            {{ nonteknis.penjelasan }}
          </p>

          <NuxtLink
            :to="nonteknis.url"
            class="
              btn btn-primary
              hover:shadow-lg
              tracking-widest
              hover:shadow-white/50
              absolute
              bottom-8
              right-8
              left-8
            "
          >
            Informasi Divisi
          </NuxtLink>
        </div>
      </div>
    </div>

    <Footer />
  </div>
</template>

<script>
export default {
  name: 'IndexPage',
  data: () => ({
    tims: {
      sambergeni: {
        nama: 'Sambergeni',
        logo: '/assets/img/tim/sambergeni.png',
        penjelasan:
          'Sambergeni merupakan delegasi Tim Robotika UNS yang berfokus pada Kontes Robot Nasional divisi Robot Pemadam Api.',
        divisi: 'KRPAI',
        warna: {
          bg: '#BB0000',
          text: '#ffffff',
        },
        kompleksitas: {
          programmer: 50,
          elektro: 50,
          mekanik: 50,
        },
        url: '/tim#sambergeni',
      },
      maladi: {
        nama: 'Maladi',
        logo: '/assets/img/tim/maladi.png',
        penjelasan:
          'Maladi merupakan delegasi Tim Robotika UNS yang berfokus pada Kontes Robot Nasional divisi Robot Sepak Bola Beroda.',
        divisi: 'KRSBI',
        warna: {
          bg: '#0FA100',
          text: '#000000',
        },
        kompleksitas: {
          programmer: 50,
          elektro: 50,
          mekanik: 50,
        },
        url: '/tim#maladi',
      },
      werkudara: {
        nama: 'Werkudara',
        logo: '/assets/img/tim/werkudara.png',
        penjelasan:
          'Werkudara merupakan delegasi Tim Robotika UNS yang berfokus pada Kontes Robot Nasional divisi Asia-Pacific Robot Contest.',
        divisi: 'KRAI',
        warna: {
          bg: '#AA8000',
          text: '#000000',
        },
        kompleksitas: {
          programmer: 50,
          elektro: 50,
          mekanik: 50,
        },
        url: '/tim#werkudara',
      },
      sriwedari: {
        nama: 'Sriwedari',
        logo: '/assets/img/tim/sriwedari.png',
        penjelasan:
          'Sriwedari merupakan delegasi Tim Robotika UNS yang berfokus pada Kontes Robot Nasional divisi Robot Penari Tradisional.',
        divisi: 'KRSTI',
        warna: {
          bg: '#79008A',
          text: '#ffffff',
        },
        kompleksitas: {
          programmer: 50,
          elektro: 50,
          mekanik: 50,
        },
        url: '/tim#sriwedari',
      },
      dewisri: {
        nama: 'Dewisri',
        logo: '/assets/img/tim/dewisri.png',
        penjelasan:
          'Dewisri merupakan delegasi Tim Robotika UNS yang berfokus pada Kontes Robot Nasional divisi Robot Tematik.',
        divisi: 'KRTMI',
        warna: {
          bg: '#B7BF00',
          text: '#000000',
        },
        kompleksitas: {
          programmer: 50,
          elektro: 50,
          mekanik: 50,
        },
        url: '/tim#dewisri',
      },
      jaladara: {
        nama: 'Jaladara',
        logo: '/assets/img/tim/jaladara.png',
        penjelasan:
          'Jaladara merupakan delegasi Tim Robotika UNS yang berfokus pada Kontes dengan tema Robot Bawah Air (ROV).',
        divisi: 'ROV',
        warna: {
          bg: '#00519A',
          text: '#ffffff',
        },
        kompleksitas: {
          programmer: 50,
          elektro: 50,
          mekanik: 50,
        },
        url: '/tim#jaladara',
      },
    },

    divisis: {
      teknis: {
        programmer: {
          nama: 'Programmer',
          logo: '/assets/img/divisi/teknis/programmer.svg',
          penjelasan:
            'Menganalisis kebutuhan modul atau sensor. Merancang dan memodelkan sistem seperti UML, flowchart, ERD dll. Menulis kode program (C++ Arduino, Python, dll.). Men-debugging program, serta menguji atau testing program.',
          url: '/divisi#programmer',
        },
        elektro: {
          nama: 'Elektro',
          logo: '/assets/img/divisi/teknis/elektro.svg',
          penjelasan:
            'Merancang skematik, mensimulasikan, serta mencetak rangkaian listrik. Memastikan rangkaian listrik aman. Menganalisis modul atau sensor yang kemungkinan rusak. Memastikan kebutuhan daya dan arus modul atau sensor terpenuhi.',
          url: '/divisi#elektro',
        },
        mekanik: {
          nama: 'Mekanik',
          logo: '/assets/img/divisi/teknis/mekanik.svg',
          penjelasan:
            'Mendesain prototipe robot secara digital maupun fisik. Merancang mekanisme gerak robot. Menganalisis kebutuhan bahan. Memprioritaskan fungsionalitas mekanisme gerak robot. Mampu mengoperasikan alat-alat mekanik.',
          url: '/divisi#mekanik',
        },
      },
      nonteknis: {
        sekretaris: {
          nama: 'Sekretaris',
          logo: '/assets/img/divisi/nonteknis/sekretaris.svg',
          penjelasan:
            'Merancang proposal, surat-menyurat, dan segala urusan administrasi yang berkaitan dengan organisasi Robotika UNS.',
          url: '/divisi#sekretaris',
        },
        bendahara: {
          nama: 'Bendahara',
          logo: '/assets/img/divisi/nonteknis/bendahara.svg',
          penjelasan:
            'Mengajukan proposal pendanaan. Merancang RAB. Serta mengelola seluruh keuangan organisasi Robotika UNS.',
          url: '/divisi#bendahara',
        },
        internal: {
          nama: 'Internal',
          logo: '/assets/img/divisi/nonteknis/internal.svg',
          penjelasan:
            'Mengelola kegiatan organisasi. Menguatkan hubungan antar anggota di dalam organisasi maupun di luar organisasi Robotika UNS.',
          url: '/divisi#internal',
        },
        media: {
          nama: 'Media',
          logo: '/assets/img/divisi/nonteknis/media.svg',
          penjelasan:
            'Mendokumentasikan kegiatan. Serta sebagai jembatan komunikasi antara anggota dengan non-anggota di luar organisasi Robotika UNS.',
          url: '/divisi#media',
        },
      },
    },
  }),
}
</script>
