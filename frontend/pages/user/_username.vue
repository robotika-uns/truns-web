<template>
  <div>
    <Navbar />
    <div
      class="h-80 rounded-b-[5rem] bg-base-300 mt-[-9rem] shadow-2xl shadow-black/70"
    >
      <div v-if="state.isFetching" class="pt-48 px-14">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24"
          width="64"
          height="64"
          class="animate-spin m-auto"
        >
          <path fill="none" d="M0 0h24v24H0z" />
          <path
            d="M12 3a9 9 0 0 1 9 9h-2a7 7 0 0 0-7-7V3z"
            class="fill-white/50"
          />
        </svg>
      </div>
      <div
        v-if="!user && !state.isFetching"
        class="pt-48 px-14 max-w-sm m-auto"
      >
        <div class="alert alert-error">
          <div class="flex-1">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              class="w-6 h-6 mx-2 stroke-current"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"
              ></path>
            </svg>
            <label><b>User tidak ditemukan!</b></label>
          </div>
        </div>
      </div>
      <div
        v-if="user && !state.isFetching"
        class="grid grid-cols-12 gap-5 pt-36 px-14"
      >
        <div class="avatar placeholder">
          <div class="mb-8 w-28 h-28 mask mask-squircle bg-base-100">
            <img v-if="user.photo" :src="user.photo" />
            <i v-else class="ri-user-3-fill ri-4x text-primary/50"></i>
          </div>
        </div>

        <div class="col-span-6">
          <div class="text-3xl text-slate-100">
            <b>{{ singkatNama(user.name) }}</b>
            <div class="badge badge-primary align-middle select-none uppercase">
              <b>{{ user.tipe }} </b>
            </div>
            <div
              v-if="!(user.role == 'member')"
              class="badge align-middle select-none uppercase"
              :class="
                user.role == 'moderator'
                  ? 'badge-warning'
                  : user.role == 'administrator'
                  ? 'badge-error'
                  : ''
              "
            >
              <b>{{ user.role }}</b>
            </div>
          </div>
          <div class="text-slate-300 text-xl"><b>@</b>{{ user.username }}</div>
          <div class="text-slate-400 text-lg mt-5">
            {{ user.bio }}
          </div>
        </div>
        <div
          class="col-end-11 col-span-2 dropdown dropdown-hover dropdown-end cursor-pointer"
          tabindex="1"
        >
          <div
            class="shadow transition ease-in-out duration-300 hover:shadow-lg hover:shadow-black stats w-full"
          >
            <div class="stat">
              <div class="stat-title uppercase tracking-widest">Experience</div>
              <div class="stat-value">
                {{ intFormat(user.xp) }}
                <span class="font-light">XP</span>
              </div>
              <div class="stat-desc">
                Apa itu experience?
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  class="inline w-5 h-5 stroke-current"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    class="text-info"
                  ></path>
                </svg>
              </div>
            </div>
          </div>
          <div
            tabindex="1"
            class="card compact dropdown-content shadow-xl shadow-black/20 bg-base-200 rounded-box w-96 mt-5 cursor-default"
          >
            <div class="card-body">
              <h2 class="card-title tracking-widest">EXPERIENCE</h2>
              <p>
                XP atau Experience adalah total nilai akumulasi yang diperoleh
                dari aktifitas pada fordis.
              </p>
              <hr class="border-primary/50 my-5" />

              <div class="overflow-x-auto">
                <table class="table w-full table-compact">
                  <thead>
                    <tr>
                      <th class="bg-base-300">XP</th>
                      <th class="bg-base-300">Keterangan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="x in experience" :key="x">
                      <td>
                        <div class="badge badge-info align-middle font-bold">
                          +<b>{{ x.xp }}</b>
                        </div>
                      </td>
                      <td>{{ x.keterangan }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div
          class="col-end-13 col-span-2 dropdown dropdown-hover dropdown-end cursor-pointer"
          tabindex="0"
        >
          <div
            class="shadow transition ease-in-out duration-300 hover:shadow-lg hover:shadow-black stats w-full"
          >
            <div class="stat">
              <div class="stat-title uppercase tracking-widest">Reputasi</div>
              <div class="stat-value">
                <div
                  :data-tip="user.reputasi"
                  class="grid grid-cols-2 gap-1 tooltip tooltip-success"
                >
                  <div class="grid grid-cols-8 gap-1">
                    <div
                      v-for="(n, index) in 8"
                      :key="n"
                      class="py-3 my-2 rounded-sm"
                      :class="
                        user.reputasi > 16 * index
                          ? 'bg-success'
                          : 'bg-base-200'
                      "
                    ></div>
                  </div>
                  <div class="grid grid-cols-8 gap-1">
                    <div
                      v-for="(n, index) in 8"
                      :key="n"
                      class="py-3 my-2 rounded-sm"
                      :class="
                        user.reputasi > 128 + 16 * index
                          ? 'bg-success'
                          : 'bg-base-200'
                      "
                    ></div>
                  </div>
                </div>
              </div>

              <div class="stat-desc">
                Apa itu reputasi?
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  class="inline w-5 h-5 stroke-current"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    class="text-info"
                  ></path>
                </svg>
              </div>
            </div>
          </div>
          <div
            tabindex="0"
            class="card compact dropdown-content shadow-xl shadow-black/20 bg-base-200 rounded-box w-96 mt-5 cursor-default"
          >
            <div class="card-body">
              <h2 class="card-title tracking-widest">REPUTASI</h2>
              <p>
                REPUTASI adalah total nilai akumulasi yang diperoleh dari
                aktifitas pada fordis. 1 blok diatas merepresentasikan 16 nilai
                reputasi.
              </p>
              <hr class="border-primary/50 my-5" />

              <div class="overflow-x-auto">
                <table class="table w-full table-compact">
                  <thead>
                    <tr>
                      <th class="bg-base-300">REP</th>
                      <th class="bg-base-300">Keterangan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="rep in reputasi" :key="rep">
                      <td>
                        <div class="badge badge-success align-middle font-bold">
                          +<b>{{ rep.rep }}</b>
                        </div>
                      </td>
                      <td>{{ rep.keterangan }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="px-24 pt-14 grid grid-cols-12 gap-10">
      <div class="col-span-4 pt-11">
        <div v-if="state.isFetching" class="px-14">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            width="64"
            height="64"
            class="animate-spin m-auto"
          >
            <path fill="none" d="M0 0h24v24H0z" />
            <path
              d="M12 3a9 9 0 0 1 9 9h-2a7 7 0 0 0-7-7V3z"
              class="fill-white/50"
            />
          </svg>
        </div>
        <div v-if="user && user.journey == ''">
          <div
            class="card bg-base-100 shadow-lg shadow-black/20 transition ease-in-out duration-300 hover:shadow-lg hover:shadow-black border-2 border-primary/10 relative select-none z-10"
          >
            <div class="flex bg-base-300/50 p-5">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                class="w-28 pr-3"
              >
                <path fill="none" d="M0 0h24v24H0z" />
                <path
                  d="M17 13a4 4 0 1 1 0 8c-2.142 0-4-1.79-4-4h-2a4 4 0 1 1-.535-2h3.07A3.998 3.998 0 0 1 17 13zM2 12v-2h2V7a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4v3h2v2H2z"
                  class="fill-primary/50"
                />
              </svg>
              <div class="card-title my-auto">
                <div class="font-light text-lg tracking-widest uppercase">
                  <div class="badge badge-neutral align-middle font-bold">
                    Non-Anggota
                  </div>
                  <!-- Outsider -->
                </div>
                <span class="uppercase tracking-widest text-3xl">
                  Outsider
                </span>
                <div class="font-light text-lg tracking-widest">
                  {{ bulan(user.created_at) }},
                  <b>{{ tahun(user.created_at) }}</b>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div v-if="user && !state.isFetching">
          <div v-for="(journey, index) in user.journey" :key="journey.id">
            <div
              v-if="!(index == 0)"
              class="h-10 ml-16 border-l-2 border-primary/10"
            ></div>
            <div
              class="card bg-base-100 shadow-lg shadow-black/20 transition ease-in-out duration-300 hover:shadow-lg hover:shadow-black border-2 border-primary/10 relative select-none z-10"
            >
              <div class="flex bg-base-300/50 p-5">
                <img
                  v-if="!(journey.tim == 'pengurus')"
                  :src="`/assets/img/tim/${journey.tim}.png`"
                  class="w-28 pr-3"
                />
                <svg
                  v-else
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  class="w-28 pr-3"
                >
                  <path fill="none" d="M0 0h24v24H0z" />
                  <path
                    d="M3.783 2.826L12 1l8.217 1.826a1 1 0 0 1 .783.976v9.987a6 6 0 0 1-2.672 4.992L12 23l-6.328-4.219A6 6 0 0 1 3 13.79V3.802a1 1 0 0 1 .783-.976zM12 13.5l2.939 1.545-.561-3.272 2.377-2.318-3.286-.478L12 6l-1.47 2.977-3.285.478 2.377 2.318-.56 3.272L12 13.5z"
                    class="fill-white"
                  />
                </svg>
                <div class="card-title my-auto">
                  <div class="font-light text-lg tracking-widest uppercase">
                    <div
                      v-if="journey.struktur"
                      class="badge badge-primary align-middle font-bold"
                    >
                      {{ journey.struktur.replace('_', ' ') }}
                    </div>
                    {{ journey.divisi }}
                  </div>
                  <span class="uppercase tracking-widest text-3xl">
                    {{ journey.tim }}
                  </span>
                  <div class="font-light text-lg tracking-widest">
                    {{ bulan(journey.created_at) }},
                    <b>{{ tahun(journey.created_at) }}</b>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-span-8">
        <div v-if="state.isFetching" class="px-14 pt-14">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            width="64"
            height="64"
            class="animate-spin m-auto"
          >
            <path fill="none" d="M0 0h24v24H0z" />
            <path
              d="M12 3a9 9 0 0 1 9 9h-2a7 7 0 0 0-7-7V3z"
              class="fill-white/50"
            />
          </svg>
        </div>
        <div v-if="user && !state.isFetching">
          <div class="tabs">
            <a
              class="tab tab-lg tab-lifted uppercase tracking-widest text-white font-medium"
              >Aktifitas</a
            >
            <!-- <a
            class="
              tab tab-lg tab-lifted
              uppercase
              font-light
              tracking-widest
              tab-active
            "
            >Journey</a
          > -->
          </div>
          <div class="bg-base-200 rounded-xl p-8">
            <div class="text-center">Coming soon!</div>
            <!-- <div class="alert bg-base-100">
            <div class="flex-1">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="#2196f3"
                class="flex-shrink-0 w-6 h-6 mx-2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                ></path>
              </svg>
              <label>
                <h4>asdasd</h4>
                <p class="text-sm text-base-content text-opacity-60">
                  2 menit yang lalu.
                </p>
              </label>
            </div>
          </div> -->
          </div>
        </div>
      </div>
    </div>

    <Footer />
  </div>
</template>

<script>
import { format, getYear } from 'date-fns'
import { id } from 'date-fns/locale'

export default {
  name: 'UserPage',

  data() {
    return {
      notifications: null,
      user: {
        name: '',
      },
      experience: {
        kasus_baru: {
          xp: 128,
          keterangan: 'Membuat kasus baru.',
        },
        menjawab_kasus: {
          xp: 256,
          keterangan: 'Menjawab kasus.',
        },
        mendapat_upvote: {
          xp: 512,
          keterangan: 'Mendapat upvote.',
        },
        menyelesaikan_kasus: {
          xp: 1024,
          keterangan: 'Menyelesaikan kasus.',
        },
      },
      reputasi: {
        mendapat_upvote: {
          rep: 1,
          keterangan: 'Mendapat upvote.',
        },
        menyelesaikan_kasus: {
          rep: 2,
          keterangan: 'Menyelesaikan kasus.',
        },
      },
      state: {
        isFetching: true,
        error: '',
      },
    }
  },
  async fetch() {
    this.state.isFetching = true
    await this.$axios
      .get(`${this.$config.apiURL}/user/${this.$route.params.username}`)
      .then((response) => {
        this.user = response.data.data
      })
      .catch(() => {
        this.user = null
      })
    this.state.isFetching = false
  },
  head() {
    return {
      title: this.user.name
        ? `${this.singkatNama(this.user.name)} - @${this.user.username} | ${
            this.$config.appName
          }`
        : `User tidak ditemukan | ${this.$config.appName}`,
    }
  },
  methods: {
    bulan(tanggal) {
      return format(new Date(tanggal), 'MMMM', { locale: id })
    },
    tahun(tanggal) {
      return getYear(new Date(tanggal))
    },
    intFormat(n) {
      if (n < 1e3) return n
      if (n >= 1e3 && n < 1e6) return +(n / 1e3).toFixed(1) + 'rb'
      if (n >= 1e6 && n < 1e9) return +(n / 1e6).toFixed(1) + 'jt'
      if (n >= 1e9 && n < 1e12) return +(n / 1e9).toFixed(1) + 'm'
      if (n >= 1e12) return +(n / 1e12).toFixed(1) + 'T'
    },
    singkatNama(name) {
      const singkat = [name[0]]
      for (let i = 0; i < name.length; i++) {
        if (name[i] === ' ') {
          singkat.push(name[i + 1])
        }
      }
      const hasil = singkat
        .map((el) => el.toUpperCase())
        .join('. ')
        .substring(6)

      const first2 = name.split(' ').slice(0, 2).join(' ')
      const lastdot = hasil ? '.' : ''
      return first2 + ' ' + hasil + lastdot
    },
  },
}
</script>
