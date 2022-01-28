### [ **Base API URL** ]
```dart
https://robotika.uns.ac.id/api
```

<br>

***

<br>

### [ **Authentication** ] - Login

<br>

![](https://img.shields.io/badge/Route%20|%20Header%20|%20Body-POST-purple?style=for-the-badge&labelColor=2e2e2e)
```dart
/auth/login
```
```dart
Authorization Bearer ...
```
```json
{
  "email" : "...",
  "password" : "..."
}
```

<br>

![](https://img.shields.io/badge/RESPONSE-2e2e2e?style=for-the-badge)

![](https://img.shields.io/badge/Login%20Berhasil-200%20OK-2e9900?labelColor=2e2e2e)
```json
{
  "tag": "login_success",
  "message": "Login berhasil."
}
```

<br>

![](https://img.shields.io/badge/Password%20Salah-400%20Bad%20Request-ff0000?labelColor=2e2e2e)
```json
{
  "tag": "wrong_credentials",
  "message": "Email atau password salah."
}
```

<br>

![](https://img.shields.io/badge/Email%20Tidak%20Terdaftar-400%20Bad%20Request-ff0000?labelColor=2e2e2e)
```json
{
  "tag": "email_not_exists",
  "message": "Email tidak terdaftar."
}
```