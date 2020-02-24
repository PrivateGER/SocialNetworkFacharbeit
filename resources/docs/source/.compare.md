---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost/docs/collection.json)

<!-- END_INFO -->

#general


<!-- START_e04cc65cf00a6c359129d6815c2a4523 -->
## api/auth/info
> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/auth/info" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/auth/info"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (400):

```json
{
    "err": true,
    "msg": "No token supplied."
}
```

### HTTP Request
`GET api/auth/info`


<!-- END_e04cc65cf00a6c359129d6815c2a4523 -->

<!-- START_a925a8d22b3615f12fca79456d286859 -->
## api/auth/login
> Example request:

```bash
curl -X POST \
    "http://localhost/api/auth/login" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/auth/login"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "err": true
}
```

### HTTP Request
`POST api/auth/login`


<!-- END_a925a8d22b3615f12fca79456d286859 -->

<!-- START_f679574fd7a448aa550d77a9520e4f0a -->
## api/post/feed
> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/post/feed" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/post/feed"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (400):

```json
{
    "err": true,
    "msg": "No token in valid format supplied."
}
```

### HTTP Request
`GET api/post/feed`


<!-- END_f679574fd7a448aa550d77a9520e4f0a -->

<!-- START_bc419fbb256c5c3b333f2d758838d618 -->
## api/post/view/{id}
> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/post/view/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/post/view/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (400):

```json
{
    "err": true,
    "msg": "No token in valid format supplied."
}
```

### HTTP Request
`GET api/post/view/{id}`


<!-- END_bc419fbb256c5c3b333f2d758838d618 -->

<!-- START_dd7681925d9cde102801763a94f5882b -->
## api/post/create
> Example request:

```bash
curl -X POST \
    "http://localhost/api/post/create" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/post/create"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (400):

```json
{
    "err": true,
    "msg": "No token in valid format supplied."
}
```

### HTTP Request
`POST api/post/create`


<!-- END_dd7681925d9cde102801763a94f5882b -->

<!-- START_60de8e160945948d718c0babb832ec84 -->
## api/post/create_comment
> Example request:

```bash
curl -X POST \
    "http://localhost/api/post/create_comment" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/post/create_comment"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (400):

```json
{
    "err": true,
    "msg": "No token in valid format supplied."
}
```

### HTTP Request
`POST api/post/create_comment`


<!-- END_60de8e160945948d718c0babb832ec84 -->

<!-- START_74be94103c7dd0550b9f2a4072c5623b -->
## api/post/report/{id}
> Example request:

```bash
curl -X POST \
    "http://localhost/api/post/report/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/post/report/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (400):

```json
{
    "err": true,
    "msg": "No token in valid format supplied."
}
```

### HTTP Request
`POST api/post/report/{id}`


<!-- END_74be94103c7dd0550b9f2a4072c5623b -->

<!-- START_b63cdac83b2d2237a663da5b6e2f6f9f -->
## api/auth/changepassword
> Example request:

```bash
curl -X POST \
    "http://localhost/api/auth/changepassword" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/auth/changepassword"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (400):

```json
{
    "err": true,
    "msg": "No token in valid format supplied."
}
```

### HTTP Request
`POST api/auth/changepassword`


<!-- END_b63cdac83b2d2237a663da5b6e2f6f9f -->


