<template>
  <div>
    <div class="hero min-h-screen mt-[-9rem]">
      <div
        class="flex-col justify-center hero-content lg:flex-row-reverse min-w-full px-5 md:px-14 z-10 pt-24"
      >
        <img src="/assets/img/illustration/tim.svg" class="p-5 md:max-w-lg" />
        <div class="w-full md:pl-10 text-center md:text-left">
          <h1 class="mb-5 text-5xl font-bold tracking-wide text-slate-100">
            <span class="font-light">TIM</span> ROBOTIKA UNS
          </h1>
          <p class="mb-5 lg:pr-32 text-white/60 tracking-wide text-2xl">
            <b>UKM Robotika UNS</b> memiliki <b>6</b> Tim yang terbagi dan
            dikategorikan berdasarkan divisi yang dilombakan.
          </p>
          <NuxtLink
            to="#sambergeni"
            class="btn btn-primary tracking-wider hover:shadow-lg hover:-translate-y-2 hover:shadow-white/50"
          >
            Lihat Tim <i class="ri-arrow-down-fill pl-2"></i>
          </NuxtLink>
        </div>
      </div>
      <Wave />
    </div>

    <div
      v-for="tim in tims"
      :id="tim.nama.toLowerCase()"
      :key="tim.nama"
      class="hero min-h-screen bg-base-300"
    >
      <div
        class="bg-no-repeat bg-contain bg-right static w-full h-full opacity-5"
        :style="`background-image: url('${tim.logo}')`"
      ></div>
      <div
        class="flex-col justify-center hero-content lg:flex-row-reverse min-w-full px-5 md:px-14 z-10 pt-24"
      >
        <img
          :src="tim.logo"
          class="p-5 md:max-w-lg transition-all ease-in-out duration-300 hover:scale-105"
        />
        <div class="w-full md:pl-10 text-center md:text-left">
          <span class="text-xl tracking-widest font-normal uppercase">{{
            tim.divisi
          }}</span>
          <h1
            class="mb-5 text-5xl font-bold tracking-wide uppercase"
            :style="`color: ${tim.warna};`"
          >
            {{ tim.nama }}
          </h1>
          <p class="mb-5 lg:pr-32 text-white/60 tracking-wide text-2xl">
            {{ tim.deskripsi }}
          </p>
        </div>
      </div>
      <Wave />
    </div>

    <div class="pb-16"></div>
  </div>
</template>

<script>
export default {
  name: 'TimPage',
  data() {
    return {
      tims: [
        {
          nama: 'Sambergeni',
          divisi: 'KRPAI',
          warna: '#BB0000',
          logo: '/assets/img/tim/sambergeni.png',
          deskripsi:
            'Sambergeni merupakan delegasi Tim Robotika UNS yang berfokus pada Kontes Robot Nasional divisi Robot Pemadam Api.',
        },
        {
          nama: 'Maladi',
          divisi: 'KRSBI',
          warna: '#0FA100',
          logo: '/assets/img/tim/maladi.png',
          deskripsi:
            'Maladi merupakan delegasi Tim Robotika UNS yang berfokus pada Kontes Robot Nasional divisi Robot Sepak Bola Beroda.',
        },
        {
          nama: 'Werkudara',
          divisi: 'KRAI',
          warna: '#AA8000',
          logo: '/assets/img/tim/werkudara.png',
          deskripsi:
            'Werkudara merupakan delegasi Tim Robotika UNS yang berfokus pada Kontes Robot Nasional divisi Asia-Pacific Robot Contest.',
        },
        {
          nama: 'Sriwedari',
          divisi: 'KRSTI',
          warna: '#79008A',
          logo: '/assets/img/tim/sriwedari.png',
          deskripsi:
            'Sriwedari merupakan delegasi Tim Robotika UNS yang berfokus pada Kontes Robot Nasional divisi Robot Penari Tradisional.',
        },
        {
          nama: 'Dewisri',
          divisi: 'KRTMI',
          warna: '#B7BF00',
          logo: '/assets/img/tim/dewisri.png',
          deskripsi:
            'Dewisri merupakan delegasi Tim Robotika UNS yang berfokus pada Kontes Robot Nasional divisi Robot Tematik.',
        },
        {
          nama: 'Jaladara',
          divisi: 'ROV',
          warna: '#00519A',
          logo: '/assets/img/tim/jaladara.png',
          deskripsi:
            'Jaladara merupakan delegasi Tim Robotika UNS yang berfokus pada Kontes dengan tema Robot Bawah Air (ROV).',
        },
      ],
    }
  },
}
</script>