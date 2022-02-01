### [ **Base API URL** ]
```dart
https://robotika.uns.ac.id/api
```

<br>

***

<br>

### [ **Authentication** ] - Login

![](https://img.shields.io/badge/POST-/auth/login-grey?labelColor=purple)

<br>

![](https://img.shields.io/badge/Body-JSON-grey?labelColor=orange) :

```json
{
  "email" : "...",
  "password" : "..."
}
```

<br>

![](https://img.shields.io/badge/Response-JSON-grey?labelColor=blue) :

|                    status                    | tag          | pesan                  | token |
| :------------------------------------------: | ------------ | ---------------------- | ----- |
| ![](https://img.shields.io/badge/200-2e9900) | login_sukses | Login berhasil.        | ✔     |
| ![](https://img.shields.io/badge/400-ff0000) | login_gagal  | Email tidak terdaftar. | -     |
| ![](https://img.shields.io/badge/400-ff0000) | login_salah  | Password salah.        | -     |


<br>



### [ **Authentication** ] - Register

![](https://img.shields.io/badge/POST-/auth/register-grey?labelColor=purple)

<br>

![](https://img.shields.io/badge/Body-JSON-grey?labelColor=orange) :

```json
{
  "name": "...",
  "email" : "...",
  "password" : "..."
}
```

<br>

![](https://img.shields.io/badge/Response-JSON-grey?labelColor=blue) :

|                    status                    | tag             | pesan                             | token |
| :------------------------------------------: | --------------- | --------------------------------- | ----- |
| ![](https://img.shields.io/badge/200-2e9900) | register_sukses | Registrasi berhasil.              | ✔     |
| ![](https://img.shields.io/badge/400-ff0000) | register_gagal  | Email sudah terdaftar sebelumnya. |       |

<br>



### [ **Authentication** ] - Verify

![](https://img.shields.io/badge/GET-/auth/verify-grey?labelColor=purple)

<br>

![](https://img.shields.io/badge/Params-URL-grey?labelColor=orange) :

```json
  token = $verify_token
```

<br>

![](https://img.shields.io/badge/Response-JSON-grey?labelColor=blue) :

|                    status                    | tag               | pesan                                         |
| :------------------------------------------: | ----------------- | --------------------------------------------- |
| ![](https://img.shields.io/badge/200-2e9900) | verify_sukses     | Email berhasil diverifikasi.                  |
| ![](https://img.shields.io/badge/403-ff0000) | verify_kadaluarsa | Link untuk verifikasi email sudah kadaluarsa. |
| ![](https://img.shields.io/badge/400-ff0000) | verify_salah      | Link untuk verifikasi email salah.            |
| ![](https://img.shields.io/badge/403-ff0000) | verify_gagal      | Email sudah diverifikasi.                     |

<br>



### [ **Authentication** ] - Resend

![](https://img.shields.io/badge/PATCH-/auth/resend-grey?labelColor=purple) ![](https://img.shields.io/badge/Authorization-Bearer%20$token-grey?labelColor=darkgreen)

<br>

![](https://img.shields.io/badge/Response-JSON-grey?labelColor=blue) :

|                    status                    | tag             | pesan                                                                |
| :------------------------------------------: | --------------- | -------------------------------------------------------------------- |
| ![](https://img.shields.io/badge/200-2e9900) | resend_sukses   | Berhasil mengirim ulang email verifikasi.diverifikasi.               |
| ![](https://img.shields.io/badge/403-ff0000) | resend_cooldown | Tunggu 60 detik lagi untuk mengirim ulang email verifikasi.          |
| ![](https://img.shields.io/badge/403-ff0000) | resend_dibatasi | Maksimal mengirim ulang email verifikasi sebanyak 5x sudah tercapai. |

<br>



### [ **Authentication** ] - Logout

![](https://img.shields.io/badge/POST-/auth/logout-grey?labelColor=purple) ![](https://img.shields.io/badge/Authorization-Bearer%20$token-grey?labelColor=darkgreen)

<br>

![](https://img.shields.io/badge/Response-JSON-grey?labelColor=blue) :

|                    status                    | tag           | pesan            |
| :------------------------------------------: | ------------- | ---------------- |
| ![](https://img.shields.io/badge/200-2e9900) | logout_sukses | Logout berhasil. |

<br>

---