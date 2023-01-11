---
title: API Reference

language_tabs:
- php
- python
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://domain.ltd/docs/collection.json)

<!-- END_INFO -->

#general


<!-- START_c6c5c00d6ac7f771f157dff4a2889b1a -->
## _debugbar/open
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/_debugbar/open',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/_debugbar/open'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/_debugbar/open"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
null
```

### HTTP Request
`GET _debugbar/open`


<!-- END_c6c5c00d6ac7f771f157dff4a2889b1a -->

<!-- START_7b167949c615f4a7e7b673f8d5fdaf59 -->
## Return Clockwork output

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/_debugbar/clockwork/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/_debugbar/clockwork/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/_debugbar/clockwork/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
null
```

### HTTP Request
`GET _debugbar/clockwork/{id}`


<!-- END_7b167949c615f4a7e7b673f8d5fdaf59 -->

<!-- START_01a252c50bd17b20340dbc5a91cea4b7 -->
## _debugbar/telescope/{id}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/_debugbar/telescope/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/_debugbar/telescope/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/_debugbar/telescope/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
null
```

### HTTP Request
`GET _debugbar/telescope/{id}`


<!-- END_01a252c50bd17b20340dbc5a91cea4b7 -->

<!-- START_5f8a640000f5db43332951f0d77378c4 -->
## Return the stylesheets for the Debugbar

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/_debugbar/assets/stylesheets',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/_debugbar/assets/stylesheets'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/_debugbar/assets/stylesheets"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
null
```

### HTTP Request
`GET _debugbar/assets/stylesheets`


<!-- END_5f8a640000f5db43332951f0d77378c4 -->

<!-- START_db7a887cf930ce3c638a8708fd1a75ee -->
## Return the javascript for the Debugbar

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/_debugbar/assets/javascript',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/_debugbar/assets/javascript'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/_debugbar/assets/javascript"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
null
```

### HTTP Request
`GET _debugbar/assets/javascript`


<!-- END_db7a887cf930ce3c638a8708fd1a75ee -->

<!-- START_0973671c4f56e7409202dc85c868d442 -->
## Forget a cache key

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/_debugbar/cache/1/',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/_debugbar/cache/1/'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/_debugbar/cache/1/"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE _debugbar/cache/{key}/{tags?}`


<!-- END_0973671c4f56e7409202dc85c868d442 -->

<!-- START_c4b26e2f0000bc2bab9bdc221b8ff298 -->
## uploads/{path}/{imagename}.{type}?resizer=1&amp;w={w}&amp;h={h}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/uploads/1/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/uploads/1/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/uploads/1/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
null
```

### HTTP Request
`GET uploads/{path}/{imagename}.{type}?resizer=1&amp;w={w}&amp;h={h}`


<!-- END_c4b26e2f0000bc2bab9bdc221b8ff298 -->

<!-- START_cd58324e6c0b8433f9fec98ebf63b7d6 -->
## cms
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms`


<!-- END_cd58324e6c0b8433f9fec98ebf63b7d6 -->

<!-- START_853f1b5aa7ee15bd8f120243415e7a39 -->
## cms/logout
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/logout',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/logout'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/logout"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/logout`


<!-- END_853f1b5aa7ee15bd8f120243415e7a39 -->

<!-- START_a791bca1d5314ed5605f93afe5d92f11 -->
## cms/users
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/users',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/users'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/users"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/users`


<!-- END_a791bca1d5314ed5605f93afe5d92f11 -->

<!-- START_2efd7c764a00eb4a14d44f1680a93ffa -->
## cms/users/{user_id}/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/users/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/users/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/users/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/users/{user_id}/edit`


<!-- END_2efd7c764a00eb4a14d44f1680a93ffa -->

<!-- START_c93779f1f305408022de305aee50b031 -->
## cms/users/{user_id}/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/users/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/users/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/users/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/users/{user_id}/update`


<!-- END_c93779f1f305408022de305aee50b031 -->

<!-- START_a8ad8c1cc4b6a338759be468d75779f2 -->
## cms/users/{user_id}/destroy
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/users/1/destroy',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/users/1/destroy'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/users/1/destroy"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/users/{user_id}/destroy`


<!-- END_a8ad8c1cc4b6a338759be468d75779f2 -->

<!-- START_6d4507f8a9a41e821456665474fd5388 -->
## cms/users/mass_change
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/users/mass_change',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/users/mass_change'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/users/mass_change"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/users/mass_change`

`POST cms/users/mass_change`

`PUT cms/users/mass_change`

`PATCH cms/users/mass_change`

`DELETE cms/users/mass_change`

`OPTIONS cms/users/mass_change`


<!-- END_6d4507f8a9a41e821456665474fd5388 -->

<!-- START_41017fc20004603f841ff1c05ce2d0be -->
## cms/tariffs
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/tariffs',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/tariffs'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/tariffs"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/tariffs`


<!-- END_41017fc20004603f841ff1c05ce2d0be -->

<!-- START_09bc0301e544749c3a8435606007fcef -->
## cms/tariffs/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/tariffs/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/tariffs/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/tariffs/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/tariffs/create`


<!-- END_09bc0301e544749c3a8435606007fcef -->

<!-- START_63c3295ef18c2c6704bf6681ee707058 -->
## cms/tariffs/{tariff_id}/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/tariffs/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/tariffs/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/tariffs/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/tariffs/{tariff_id}/edit`


<!-- END_63c3295ef18c2c6704bf6681ee707058 -->

<!-- START_8f19eee55389e795e457f0de5ff8a079 -->
## cms/tariffs/{tariff_id}/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/tariffs/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/tariffs/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/tariffs/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/tariffs/{tariff_id}/update`


<!-- END_8f19eee55389e795e457f0de5ff8a079 -->

<!-- START_497c0a798a12e6a74b58897fd652a7f2 -->
## cms/tariffs/{tariff_id}/destroy
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/tariffs/1/destroy',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/tariffs/1/destroy'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/tariffs/1/destroy"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/tariffs/{tariff_id}/destroy`


<!-- END_497c0a798a12e6a74b58897fd652a7f2 -->

<!-- START_f0e82575c3d58d399998f7c9ce151ad5 -->
## cms/tariffs/store
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/tariffs/store',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/tariffs/store'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/tariffs/store"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/tariffs/store`


<!-- END_f0e82575c3d58d399998f7c9ce151ad5 -->

<!-- START_c67d4dae1f45cb794dcbdfe17787fc6e -->
## cms/services
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/services',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/services'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/services"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/services`


<!-- END_c67d4dae1f45cb794dcbdfe17787fc6e -->

<!-- START_fc20264c11bcf33f21f43569b71b802d -->
## cms/services/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/services/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/services/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/services/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/services/create`


<!-- END_fc20264c11bcf33f21f43569b71b802d -->

<!-- START_96bead9d3055637a7a80a71ec7da3bc7 -->
## cms/services/store
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/services/store',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/services/store'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/services/store"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/services/store`


<!-- END_96bead9d3055637a7a80a71ec7da3bc7 -->

<!-- START_7255eba0731ccddfa37f20a9ef06d7e4 -->
## cms/services/{services}/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/services/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/services/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/services/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/services/{services}/edit`


<!-- END_7255eba0731ccddfa37f20a9ef06d7e4 -->

<!-- START_a65ba2725a7907d73060d5d06a44606f -->
## cms/services/{services}/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/services/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/services/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/services/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/services/{services}/update`


<!-- END_a65ba2725a7907d73060d5d06a44606f -->

<!-- START_ec3a826d27732418d678592e617fffa2 -->
## cms/services/{services}/destroy
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/services/1/destroy',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/services/1/destroy'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/services/1/destroy"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/services/{services}/destroy`


<!-- END_ec3a826d27732418d678592e617fffa2 -->

<!-- START_dee04e552e18f5e0fbe9c9ed2760c60b -->
## cms/discounts
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/discounts',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/discounts'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/discounts"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/discounts`


<!-- END_dee04e552e18f5e0fbe9c9ed2760c60b -->

<!-- START_5771939c01f0a5a8c8a4a0679fc2ca41 -->
## cms/discounts/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/discounts/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/discounts/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/discounts/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/discounts/create`


<!-- END_5771939c01f0a5a8c8a4a0679fc2ca41 -->

<!-- START_8e23670a65d6128a0e14cb162e0a4fa1 -->
## cms/discounts/store
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/discounts/store',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/discounts/store'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/discounts/store"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/discounts/store`


<!-- END_8e23670a65d6128a0e14cb162e0a4fa1 -->

<!-- START_0cc3ff73d86f39539a4cb90532a29a7d -->
## cms/discounts/{services}/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/discounts/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/discounts/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/discounts/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/discounts/{services}/edit`


<!-- END_0cc3ff73d86f39539a4cb90532a29a7d -->

<!-- START_7089bf68efc6eadc96e98072d6e5fdd8 -->
## cms/discounts/{services}/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/discounts/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/discounts/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/discounts/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/discounts/{services}/update`


<!-- END_7089bf68efc6eadc96e98072d6e5fdd8 -->

<!-- START_8af2449e54aae730c1e459afd1e49a99 -->
## cms/discounts/{services}/destroy
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/discounts/1/destroy',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/discounts/1/destroy'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/discounts/1/destroy"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/discounts/{services}/destroy`


<!-- END_8af2449e54aae730c1e459afd1e49a99 -->

<!-- START_611fe4aec86d6812bb40b43f014a0482 -->
## cms/constructor
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/constructor',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/constructor'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/constructor"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/constructor`


<!-- END_611fe4aec86d6812bb40b43f014a0482 -->

<!-- START_5310222cd52e918307deed8d7f84a3a0 -->
## cms/constructor/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/constructor/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/constructor/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/constructor/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/constructor/create`


<!-- END_5310222cd52e918307deed8d7f84a3a0 -->

<!-- START_71779fb7a86ac74e1862ce69f479d7b9 -->
## cms/constructor/{constructor}/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/constructor/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/constructor/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/constructor/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/constructor/{constructor}/edit`


<!-- END_71779fb7a86ac74e1862ce69f479d7b9 -->

<!-- START_8d1ba88cbe9ecc308f7bc230c464e3e2 -->
## cms/constructor/{constructor}/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/constructor/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/constructor/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/constructor/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/constructor/{constructor}/update`


<!-- END_8d1ba88cbe9ecc308f7bc230c464e3e2 -->

<!-- START_9886be014204d08ea0f81200b85c83db -->
## cms/constructor/store
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/constructor/store',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/constructor/store'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/constructor/store"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/constructor/store`


<!-- END_9886be014204d08ea0f81200b85c83db -->

<!-- START_90d3c24aab78942ec6e6dd6e3596d916 -->
## cms/constructor/{constructor}/destroy
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/constructor/1/destroy',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/constructor/1/destroy'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/constructor/1/destroy"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/constructor/{constructor}/destroy`


<!-- END_90d3c24aab78942ec6e6dd6e3596d916 -->

<!-- START_4f8f5c581640a18e6ceb6e93d98b149e -->
## cms/roles
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/roles',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/roles'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/roles"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/roles`


<!-- END_4f8f5c581640a18e6ceb6e93d98b149e -->

<!-- START_a210087ab949890f1cd0821ae09cbe54 -->
## cms/roles/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/roles/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/roles/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/roles/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/roles/create`


<!-- END_a210087ab949890f1cd0821ae09cbe54 -->

<!-- START_8113220942bc8b8854747387bb621206 -->
## cms/roles
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/roles',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/roles'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/roles"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/roles`


<!-- END_8113220942bc8b8854747387bb621206 -->

<!-- START_6ee45c14784fa3cce1bb267a4a6e0739 -->
## cms/roles/{role}/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/roles/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/roles/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/roles/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/roles/{role}/edit`


<!-- END_6ee45c14784fa3cce1bb267a4a6e0739 -->

<!-- START_473f3187992a5ce15433031e222e50f9 -->
## cms/roles/{role}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'https://domain.ltd/cms/roles/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/roles/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('PUT', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/roles/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT cms/roles/{role}`

`PATCH cms/roles/{role}`


<!-- END_473f3187992a5ce15433031e222e50f9 -->

<!-- START_945f92f75f775300812f200fda2b5e2f -->
## cms/roles/{role}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/roles/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/roles/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/roles/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/roles/{role}`


<!-- END_945f92f75f775300812f200fda2b5e2f -->

<!-- START_83f9153745344cfb2b2f7dc3c6ea1f53 -->
## cms/roles/{roles}/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/roles/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/roles/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/roles/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/roles/{roles}/update`


<!-- END_83f9153745344cfb2b2f7dc3c6ea1f53 -->

<!-- START_94c27d708f0b94d4188440466f23fd1a -->
## Display a listing of the resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/domains',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/domains'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/domains"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/domains`


<!-- END_94c27d708f0b94d4188440466f23fd1a -->

<!-- START_ca68e84a5a2f99541a4a273c61513279 -->
## Show the form for creating a new resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/domains/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/domains/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/domains/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/domains/create`


<!-- END_ca68e84a5a2f99541a4a273c61513279 -->

<!-- START_8c30e9e7794789e9750f164a18cf03d4 -->
## Store a newly created resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/domains',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/domains'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/domains"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/domains`


<!-- END_8c30e9e7794789e9750f164a18cf03d4 -->

<!-- START_d24d8ec5258419232b06cd2b4b38362d -->
## Display the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/domains/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/domains/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/domains/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/domains/{domain}`


<!-- END_d24d8ec5258419232b06cd2b4b38362d -->

<!-- START_399141010d08229bba81eb7ea2219ebb -->
## Show the form for editing the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/domains/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/domains/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/domains/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/domains/{domain}/edit`


<!-- END_399141010d08229bba81eb7ea2219ebb -->

<!-- START_cef8b2b683b462bc582f0f676031811e -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'https://domain.ltd/cms/domains/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/domains/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('PUT', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/domains/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT cms/domains/{domain}`

`PATCH cms/domains/{domain}`


<!-- END_cef8b2b683b462bc582f0f676031811e -->

<!-- START_efab7ecda292bfd407e75f22406bea6e -->
## Remove the specified resource from storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/domains/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/domains/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/domains/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/domains/{domain}`


<!-- END_efab7ecda292bfd407e75f22406bea6e -->

<!-- START_56a66cc1f1c4d056e4624e6884670e14 -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/domains/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/domains/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/domains/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/domains/{domains}/update`


<!-- END_56a66cc1f1c4d056e4624e6884670e14 -->

<!-- START_765d7af57ce96ae3eab3ed4170afffe0 -->
## Display a listing of the resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/permissions',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/permissions'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/permissions"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/permissions`


<!-- END_765d7af57ce96ae3eab3ed4170afffe0 -->

<!-- START_01ca3d7c085d056dcaab57720811fdf9 -->
## Show the form for creating a new resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/permissions/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/permissions/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/permissions/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/permissions/create`


<!-- END_01ca3d7c085d056dcaab57720811fdf9 -->

<!-- START_e6b280b8df989b4f8c8b6a7862b13932 -->
## Store a newly created resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/permissions',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/permissions'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/permissions"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/permissions`


<!-- END_e6b280b8df989b4f8c8b6a7862b13932 -->

<!-- START_954809265938277274f6608f585de131 -->
## Display the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/permissions/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/permissions/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/permissions/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/permissions/{permission}`


<!-- END_954809265938277274f6608f585de131 -->

<!-- START_0fbbf8c878933187116b07a90a46a0be -->
## Show the form for editing the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/permissions/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/permissions/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/permissions/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/permissions/{permission}/edit`


<!-- END_0fbbf8c878933187116b07a90a46a0be -->

<!-- START_a5a49cece0a902d51b933acf041a95b2 -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'https://domain.ltd/cms/permissions/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/permissions/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('PUT', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/permissions/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT cms/permissions/{permission}`

`PATCH cms/permissions/{permission}`


<!-- END_a5a49cece0a902d51b933acf041a95b2 -->

<!-- START_5f5e55b8afb6beffee0ad02c1af24701 -->
## Remove the specified resource from storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/permissions/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/permissions/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/permissions/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/permissions/{permission}`


<!-- END_5f5e55b8afb6beffee0ad02c1af24701 -->

<!-- START_58cf74977f24538a45b71250d54feec8 -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/permissions/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/permissions/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/permissions/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/permissions/{permissions}/update`


<!-- END_58cf74977f24538a45b71250d54feec8 -->

<!-- START_2d166516468b49fdbb81a819a49b509a -->
## Display a listing of the resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/forms',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/forms'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/forms"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/forms`


<!-- END_2d166516468b49fdbb81a819a49b509a -->

<!-- START_aae284aa5640089edf5ea79c391130b0 -->
## Show the form for creating a new resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/forms/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/forms/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/forms/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/forms/create`


<!-- END_aae284aa5640089edf5ea79c391130b0 -->

<!-- START_ce7a5a7e16ce781c3da497d23fc6618f -->
## Store a newly created resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/forms',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/forms'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/forms"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/forms`


<!-- END_ce7a5a7e16ce781c3da497d23fc6618f -->

<!-- START_c28bfdaaf1837a81da68c851f65f883f -->
## Display the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/forms/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/forms/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/forms/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/forms/{form}`


<!-- END_c28bfdaaf1837a81da68c851f65f883f -->

<!-- START_43dd0710af7c8f7edee588d781a6d11f -->
## Show the form for editing the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/forms/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/forms/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/forms/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/forms/{form}/edit`


<!-- END_43dd0710af7c8f7edee588d781a6d11f -->

<!-- START_f86c3ed2ff143147b2b6dfc3aa1b9769 -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'https://domain.ltd/cms/forms/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/forms/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('PUT', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/forms/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT cms/forms/{form}`

`PATCH cms/forms/{form}`


<!-- END_f86c3ed2ff143147b2b6dfc3aa1b9769 -->

<!-- START_53fc14ef326aa16fa395c8b25758c871 -->
## Remove the specified resource from storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/forms/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/forms/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/forms/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/forms/{form}`


<!-- END_53fc14ef326aa16fa395c8b25758c871 -->

<!-- START_0600f15ae5bd7362ed17bf411edbf48a -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/forms/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/forms/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/forms/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/forms/{forms}/update`


<!-- END_0600f15ae5bd7362ed17bf411edbf48a -->

<!-- START_8ecc02d6dabd8c31e6397c671e0a7002 -->
## Display a listing of the resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/form_groups',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/form_groups'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/form_groups"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/form_groups`


<!-- END_8ecc02d6dabd8c31e6397c671e0a7002 -->

<!-- START_59608f61d11d8aa8ad39d60be096bf9f -->
## Show the form for creating a new resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/form_groups/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/form_groups/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/form_groups/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/form_groups/create`


<!-- END_59608f61d11d8aa8ad39d60be096bf9f -->

<!-- START_f7ebfc8108be302b41402b71346e0088 -->
## Store a newly created resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/form_groups',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/form_groups'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/form_groups"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/form_groups`


<!-- END_f7ebfc8108be302b41402b71346e0088 -->

<!-- START_889b01f8510638ab66c33ace44946562 -->
## Display the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/form_groups/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/form_groups/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/form_groups/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/form_groups/{form_group}`


<!-- END_889b01f8510638ab66c33ace44946562 -->

<!-- START_a1cd097d7abee16c6989151c32e823f7 -->
## Show the form for editing the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/form_groups/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/form_groups/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/form_groups/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/form_groups/{form_group}/edit`


<!-- END_a1cd097d7abee16c6989151c32e823f7 -->

<!-- START_034cabcd7aaea9a1160bd88a337b7de9 -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'https://domain.ltd/cms/form_groups/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/form_groups/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('PUT', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/form_groups/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT cms/form_groups/{form_group}`

`PATCH cms/form_groups/{form_group}`


<!-- END_034cabcd7aaea9a1160bd88a337b7de9 -->

<!-- START_72cf91d591bb4a49ad981d524a9dfcaa -->
## Remove the specified resource from storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/form_groups/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/form_groups/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/form_groups/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/form_groups/{form_group}`


<!-- END_72cf91d591bb4a49ad981d524a9dfcaa -->

<!-- START_acc9a81eb5ada350a37561a0d934a939 -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/form_groups/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/form_groups/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/form_groups/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/form_groups/{form_groups}/update`


<!-- END_acc9a81eb5ada350a37561a0d934a939 -->

<!-- START_ede5b6b5a7098be2636dd0eb7845fbcd -->
## cms/form_groups/updateTree
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/form_groups/updateTree',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/form_groups/updateTree'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/form_groups/updateTree"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/form_groups/updateTree`


<!-- END_ede5b6b5a7098be2636dd0eb7845fbcd -->

<!-- START_fe8fd16e3325bfcd83891fb1cf3dd2f2 -->
## Display a listing of the resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/feedback',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/feedback'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/feedback"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/feedback`


<!-- END_fe8fd16e3325bfcd83891fb1cf3dd2f2 -->

<!-- START_631149e2169cb5110e2dcf900d5a65ba -->
## Show the form for creating a new resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/feedback/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/feedback/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/feedback/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/feedback/create`


<!-- END_631149e2169cb5110e2dcf900d5a65ba -->

<!-- START_4e4e8ac8fb16cc5ff07e99e355adfc4d -->
## Store a newly created resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/feedback',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/feedback'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/feedback"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/feedback`


<!-- END_4e4e8ac8fb16cc5ff07e99e355adfc4d -->

<!-- START_c065fe03c64d1d754038aa741a4fd24b -->
## Display the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/feedback/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/feedback/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/feedback/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/feedback/{feedback}`


<!-- END_c065fe03c64d1d754038aa741a4fd24b -->

<!-- START_236f78f18b881f7fcf180b4925e4fcd4 -->
## Show the form for editing the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/feedback/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/feedback/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/feedback/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/feedback/{feedback}/edit`


<!-- END_236f78f18b881f7fcf180b4925e4fcd4 -->

<!-- START_56596b9a6abda5355e6fe39a53c22929 -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'https://domain.ltd/cms/feedback/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/feedback/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('PUT', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/feedback/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT cms/feedback/{feedback}`

`PATCH cms/feedback/{feedback}`


<!-- END_56596b9a6abda5355e6fe39a53c22929 -->

<!-- START_69277b5e955dd9011e342df56a374e0b -->
## Remove the specified resource from storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/feedback/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/feedback/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/feedback/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/feedback/{feedback}`


<!-- END_69277b5e955dd9011e342df56a374e0b -->

<!-- START_95a0282958b96045c446753be48a5f49 -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/feedback/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/feedback/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/feedback/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/feedback/{feedback}/update`


<!-- END_95a0282958b96045c446753be48a5f49 -->

<!-- START_cd5aa50a5042d9940e24e45a5951650d -->
## Display a listing of the resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/site_sections',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/site_sections'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/site_sections"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/site_sections`


<!-- END_cd5aa50a5042d9940e24e45a5951650d -->

<!-- START_0942a27999c6cde67708cdec8d433c49 -->
## Show the form for creating a new resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/site_sections/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/site_sections/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/site_sections/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/site_sections/create`


<!-- END_0942a27999c6cde67708cdec8d433c49 -->

<!-- START_650199bf08a8ba3497edba7d122d06dc -->
## Store a newly created resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/site_sections',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/site_sections'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/site_sections"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/site_sections`


<!-- END_650199bf08a8ba3497edba7d122d06dc -->

<!-- START_5824578b361abe8ca605090df1877d36 -->
## Display the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/site_sections/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/site_sections/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/site_sections/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/site_sections/{site_section}`


<!-- END_5824578b361abe8ca605090df1877d36 -->

<!-- START_ac4ceac5bee3651f2d8b43268a7928cb -->
## Show the form for editing the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/site_sections/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/site_sections/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/site_sections/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/site_sections/{site_section}/edit`


<!-- END_ac4ceac5bee3651f2d8b43268a7928cb -->

<!-- START_cbba8675bfa0ec16eb0d93e0a9454bb5 -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'https://domain.ltd/cms/site_sections/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/site_sections/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('PUT', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/site_sections/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT cms/site_sections/{site_section}`

`PATCH cms/site_sections/{site_section}`


<!-- END_cbba8675bfa0ec16eb0d93e0a9454bb5 -->

<!-- START_29a4268a5a65733581d736fd73cfe84b -->
## Remove the specified resource from storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/site_sections/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/site_sections/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/site_sections/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/site_sections/{site_section}`


<!-- END_29a4268a5a65733581d736fd73cfe84b -->

<!-- START_c60209ced2116f504aeea7675af47deb -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/site_sections/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/site_sections/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/site_sections/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/site_sections/{site_sections}/update`


<!-- END_c60209ced2116f504aeea7675af47deb -->

<!-- START_d5938562f19fb7c3b856bf89b057e9dd -->
## Display a listing of the resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/sites',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/sites'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/sites"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/sites`


<!-- END_d5938562f19fb7c3b856bf89b057e9dd -->

<!-- START_83f4b1540bad9470f112a6d54af59ac1 -->
## Show the form for creating a new resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/sites/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/sites/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/sites/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/sites/create`


<!-- END_83f4b1540bad9470f112a6d54af59ac1 -->

<!-- START_988214f91c6c28a067501e69049365f1 -->
## Store a newly created resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/sites',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/sites'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/sites"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/sites`


<!-- END_988214f91c6c28a067501e69049365f1 -->

<!-- START_c5f71e9de6bc30aaad9745936123c2ac -->
## Display the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/sites/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/sites/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/sites/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/sites/{site}`


<!-- END_c5f71e9de6bc30aaad9745936123c2ac -->

<!-- START_67245111721b379f2d6d93ff58a66602 -->
## Show the form for editing the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/sites/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/sites/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/sites/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/sites/{site}/edit`


<!-- END_67245111721b379f2d6d93ff58a66602 -->

<!-- START_5c16f3f06c6ccd7e32a1863d80b24742 -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'https://domain.ltd/cms/sites/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/sites/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('PUT', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/sites/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT cms/sites/{site}`

`PATCH cms/sites/{site}`


<!-- END_5c16f3f06c6ccd7e32a1863d80b24742 -->

<!-- START_a3449c106fcebd71dde69a0d47700a06 -->
## Remove the specified resource from storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/sites/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/sites/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/sites/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/sites/{site}`


<!-- END_a3449c106fcebd71dde69a0d47700a06 -->

<!-- START_5bf635b1652054d3a86957e5ccd8f415 -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/sites/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/sites/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/sites/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/sites/{sites}/update`


<!-- END_5bf635b1652054d3a86957e5ccd8f415 -->

<!-- START_73398209dad00e77f9c469fae7e621f1 -->
## cms/sites/updateTree
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/sites/updateTree',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/sites/updateTree'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/sites/updateTree"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/sites/updateTree`


<!-- END_73398209dad00e77f9c469fae7e621f1 -->

<!-- START_e93d270efd4b4b27f8eca97ea3e85763 -->
## cms/sites/{sites}/undelete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/sites/1/undelete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/sites/1/undelete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/sites/1/undelete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/sites/{sites}/undelete`


<!-- END_e93d270efd4b4b27f8eca97ea3e85763 -->

<!-- START_0dfb5de787b881cb19a1ec94091edd3d -->
## cms/sites/{sites}/destroyForever
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/sites/1/destroyForever',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/sites/1/destroyForever'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/sites/1/destroyForever"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/sites/{sites}/destroyForever`


<!-- END_0dfb5de787b881cb19a1ec94091edd3d -->

<!-- START_5c0ea69eebf0397b7748ab006bedfce6 -->
## cms/sites/{sites}/destroyCascade
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/sites/1/destroyCascade',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/sites/1/destroyCascade'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/sites/1/destroyCascade"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/sites/{sites}/destroyCascade`


<!-- END_5c0ea69eebf0397b7748ab006bedfce6 -->

<!-- START_bd5f096f0d39eea81b30b3f02021a661 -->
## Display a listing of the resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/settings',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/settings'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/settings"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/settings`


<!-- END_bd5f096f0d39eea81b30b3f02021a661 -->

<!-- START_0a9938c7afa3c977be4deddd1fb45ec7 -->
## Show the form for creating a new resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/settings/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/settings/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/settings/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/settings/create`


<!-- END_0a9938c7afa3c977be4deddd1fb45ec7 -->

<!-- START_3b41f16ee265cf78a91090933544c6cc -->
## Store a newly created resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/settings',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/settings'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/settings"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/settings`


<!-- END_3b41f16ee265cf78a91090933544c6cc -->

<!-- START_2ec3c712bd15454d354c8f1fc5829059 -->
## Display the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/settings/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/settings/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/settings/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/settings/{setting}`


<!-- END_2ec3c712bd15454d354c8f1fc5829059 -->

<!-- START_ac9cac048f86e9bab6edb95710a098ca -->
## Show the form for editing the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/settings/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/settings/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/settings/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/settings/{setting}/edit`


<!-- END_ac9cac048f86e9bab6edb95710a098ca -->

<!-- START_78bda999ff41c52298945d225dfc9da0 -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'https://domain.ltd/cms/settings/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/settings/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('PUT', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/settings/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT cms/settings/{setting}`

`PATCH cms/settings/{setting}`


<!-- END_78bda999ff41c52298945d225dfc9da0 -->

<!-- START_b1923f31bfa574aa3d373ee16215fc1e -->
## Remove the specified resource from storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/settings/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/settings/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/settings/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/settings/{setting}`


<!-- END_b1923f31bfa574aa3d373ee16215fc1e -->

<!-- START_28854844a08a2d0ef2f2f52571a1ef81 -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/settings/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/settings/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/settings/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/settings/{settings}/update`


<!-- END_28854844a08a2d0ef2f2f52571a1ef81 -->

<!-- START_e3dae9195cdae54b7ba492d7815b13ce -->
## Display a listing of the resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/site_users',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/site_users'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/site_users"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/site_users`


<!-- END_e3dae9195cdae54b7ba492d7815b13ce -->

<!-- START_203fe55c92abe9cca0858beaf311e50c -->
## Show the form for creating a new resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/site_users/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/site_users/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/site_users/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/site_users/create`


<!-- END_203fe55c92abe9cca0858beaf311e50c -->

<!-- START_79ecbc92177089e0478c4762b1246de2 -->
## Store a newly created resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/site_users',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/site_users'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/site_users"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/site_users`


<!-- END_79ecbc92177089e0478c4762b1246de2 -->

<!-- START_e1e067b57ce0c32cafa8762413408f1f -->
## Display the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/site_users/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/site_users/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/site_users/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/site_users/{site_user}`


<!-- END_e1e067b57ce0c32cafa8762413408f1f -->

<!-- START_d6d1254a75432f948e3d1bfec06afd94 -->
## Show the form for editing the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/site_users/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/site_users/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/site_users/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/site_users/{site_user}/edit`


<!-- END_d6d1254a75432f948e3d1bfec06afd94 -->

<!-- START_2a59140171060dc6d36b20c1bdabd95c -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'https://domain.ltd/cms/site_users/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/site_users/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('PUT', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/site_users/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT cms/site_users/{site_user}`

`PATCH cms/site_users/{site_user}`


<!-- END_2a59140171060dc6d36b20c1bdabd95c -->

<!-- START_80cd5a286815aecb3372493956d6bcfe -->
## Remove the specified resource from storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/site_users/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/site_users/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/site_users/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/site_users/{site_user}`


<!-- END_80cd5a286815aecb3372493956d6bcfe -->

<!-- START_e93baa7b2a96d95ef80ec89afc6c04bc -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/site_users/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/site_users/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/site_users/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/site_users/{site_users}/update`


<!-- END_e93baa7b2a96d95ef80ec89afc6c04bc -->

<!-- START_2544409b28e21e1771aaeedb8731b30e -->
## Display a listing of the resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/sections_site',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/sections_site'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/sections_site"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/sections_site`


<!-- END_2544409b28e21e1771aaeedb8731b30e -->

<!-- START_de78b5fd2ef215737836da674eec26fa -->
## Show the form for creating a new resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/sections_site/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/sections_site/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/sections_site/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/sections_site/create`


<!-- END_de78b5fd2ef215737836da674eec26fa -->

<!-- START_2d15c59211e384925735570698f81a72 -->
## Store a newly created resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/sections_site',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/sections_site'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/sections_site"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/sections_site`


<!-- END_2d15c59211e384925735570698f81a72 -->

<!-- START_77fe19eac4633db8fd2f16cd9f5b0f3e -->
## Display the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/sections_site/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/sections_site/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/sections_site/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/sections_site/{sections_site}`


<!-- END_77fe19eac4633db8fd2f16cd9f5b0f3e -->

<!-- START_9794aef9615407de341a5745ac3c394f -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'https://domain.ltd/cms/sections_site/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/sections_site/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('PUT', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/sections_site/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT cms/sections_site/{sections_site}`

`PATCH cms/sections_site/{sections_site}`


<!-- END_9794aef9615407de341a5745ac3c394f -->

<!-- START_da67e8215fe611ca07e6cf0d9b61b8b5 -->
## Remove the specified resource from storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/sections_site/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/sections_site/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/sections_site/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/sections_site/{sections_site}`


<!-- END_da67e8215fe611ca07e6cf0d9b61b8b5 -->

<!-- START_54cf251d68f701d2bde599ca08103f9f -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/sections_site/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/sections_site/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/sections_site/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/sections_site/{sections_site}/update`


<!-- END_54cf251d68f701d2bde599ca08103f9f -->

<!-- START_c204868f2a6748eda7c2b80a46fe1022 -->
## Display a listing of the resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/templates',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/templates'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/templates"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/templates`


<!-- END_c204868f2a6748eda7c2b80a46fe1022 -->

<!-- START_bd5bacafacbadaf73193d9633a733d0c -->
## Show the form for creating a new resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/templates/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/templates/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/templates/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/templates/create`


<!-- END_bd5bacafacbadaf73193d9633a733d0c -->

<!-- START_a7fcebd455187c3e705dfe35af31f161 -->
## Store a newly created resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/templates',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/templates'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/templates"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/templates`


<!-- END_a7fcebd455187c3e705dfe35af31f161 -->

<!-- START_d33fb66312d66a4e0453e4d35adc938f -->
## Display the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/templates/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/templates/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/templates/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/templates/{template}`


<!-- END_d33fb66312d66a4e0453e4d35adc938f -->

<!-- START_45ac0c3846812404fead7a5fd9cdff17 -->
## Show the form for editing the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/templates/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/templates/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/templates/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/templates/{template}/edit`


<!-- END_45ac0c3846812404fead7a5fd9cdff17 -->

<!-- START_2691145835ab90a6994b4459547db46e -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'https://domain.ltd/cms/templates/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/templates/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('PUT', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/templates/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT cms/templates/{template}`

`PATCH cms/templates/{template}`


<!-- END_2691145835ab90a6994b4459547db46e -->

<!-- START_69c67e4c21321048a9bb12f19e93f4b6 -->
## Remove the specified resource from storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/templates/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/templates/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/templates/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/templates/{template}`


<!-- END_69c67e4c21321048a9bb12f19e93f4b6 -->

<!-- START_ab5dd2846def15315f1560f943aac96c -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/templates/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/templates/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/templates/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/templates/{templates}/update`


<!-- END_ab5dd2846def15315f1560f943aac96c -->

<!-- START_4facc72bfb74ef4d9bc181d2a45cb9ac -->
## Display a listing of the resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/footer_menu',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/footer_menu'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/footer_menu"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/footer_menu`


<!-- END_4facc72bfb74ef4d9bc181d2a45cb9ac -->

<!-- START_0b9d88ecf399262e513c9851fdb9a06a -->
## Show the form for creating a new resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/footer_menu/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/footer_menu/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/footer_menu/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/footer_menu/create`


<!-- END_0b9d88ecf399262e513c9851fdb9a06a -->

<!-- START_aa9baaa96df2f67c7fc21b34c35e87a7 -->
## Store a newly created resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/footer_menu',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/footer_menu'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/footer_menu"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/footer_menu`


<!-- END_aa9baaa96df2f67c7fc21b34c35e87a7 -->

<!-- START_1ff5ac09886ee3fc2cd1eedabc3bdca1 -->
## Display the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/footer_menu/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/footer_menu/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/footer_menu/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/footer_menu/{footer_menu}`


<!-- END_1ff5ac09886ee3fc2cd1eedabc3bdca1 -->

<!-- START_cd2002d8a030df0629825b662be30fbb -->
## Show the form for editing the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/footer_menu/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/footer_menu/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/footer_menu/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/footer_menu/{footer_menu}/edit`


<!-- END_cd2002d8a030df0629825b662be30fbb -->

<!-- START_a9dd0df3ac7b3949eb7ff55da6ee97c6 -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'https://domain.ltd/cms/footer_menu/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/footer_menu/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('PUT', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/footer_menu/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT cms/footer_menu/{footer_menu}`

`PATCH cms/footer_menu/{footer_menu}`


<!-- END_a9dd0df3ac7b3949eb7ff55da6ee97c6 -->

<!-- START_ed3858907ba3a1c6093186793f713df8 -->
## Remove the specified resource from storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/footer_menu/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/footer_menu/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/footer_menu/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/footer_menu/{footer_menu}`


<!-- END_ed3858907ba3a1c6093186793f713df8 -->

<!-- START_5a13148183a57e425ede3594afa043a5 -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/footer_menu/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/footer_menu/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/footer_menu/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/footer_menu/{footer_menu}/update`


<!-- END_5a13148183a57e425ede3594afa043a5 -->

<!-- START_af2fe785d24d11550ff7bb75447d315a -->
## Display a listing of the resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/slider',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/slider'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/slider"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/slider`


<!-- END_af2fe785d24d11550ff7bb75447d315a -->

<!-- START_13d2e95e385f6a924589126572887fab -->
## Show the form for creating a new resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/slider/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/slider/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/slider/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/slider/create`


<!-- END_13d2e95e385f6a924589126572887fab -->

<!-- START_5529e08c5ac9717e64ba1da9dcdc4eac -->
## Store a newly created resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/slider',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/slider'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/slider"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/slider`


<!-- END_5529e08c5ac9717e64ba1da9dcdc4eac -->

<!-- START_b3d957f30cc0df25d274bad9fb446860 -->
## Display the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/slider/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/slider/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/slider/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/slider/{slider}`


<!-- END_b3d957f30cc0df25d274bad9fb446860 -->

<!-- START_fdd2b68bf47ca4698f6a8efbd129a26e -->
## Show the form for editing the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/slider/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/slider/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/slider/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/slider/{slider}/edit`


<!-- END_fdd2b68bf47ca4698f6a8efbd129a26e -->

<!-- START_2c5bdbb9ad8faac4e840143d9ffcfaba -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'https://domain.ltd/cms/slider/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/slider/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('PUT', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/slider/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT cms/slider/{slider}`

`PATCH cms/slider/{slider}`


<!-- END_2c5bdbb9ad8faac4e840143d9ffcfaba -->

<!-- START_91ac4d977120c07d793edc00c7a3efd9 -->
## Remove the specified resource from storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/slider/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/slider/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/slider/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/slider/{slider}`


<!-- END_91ac4d977120c07d793edc00c7a3efd9 -->

<!-- START_cff0d4e7db97879845c3992f1dd10b7c -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/slider/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/slider/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/slider/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/slider/{slider}/update`


<!-- END_cff0d4e7db97879845c3992f1dd10b7c -->

<!-- START_0e9c53bdcafb9d13203d66e353cccc77 -->
## Display a listing of the resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/sections',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/sections'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/sections"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/sections`


<!-- END_0e9c53bdcafb9d13203d66e353cccc77 -->

<!-- START_845a0dc77cfb57d48e2d4338bebd35d1 -->
## Show the form for creating a new resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/sections/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/sections/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/sections/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/sections/create`


<!-- END_845a0dc77cfb57d48e2d4338bebd35d1 -->

<!-- START_12b0ce95f651e8d762145e7f2a245ccd -->
## Store a newly created resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/sections',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/sections'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/sections"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/sections`


<!-- END_12b0ce95f651e8d762145e7f2a245ccd -->

<!-- START_93910d8ff287828311a5f4ed378a997a -->
## Display the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/sections/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/sections/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/sections/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/sections/{section}`


<!-- END_93910d8ff287828311a5f4ed378a997a -->

<!-- START_eace384697085ed0e237b0290953b1a2 -->
## Show the form for editing the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/sections/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/sections/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/sections/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/sections/{section}/edit`


<!-- END_eace384697085ed0e237b0290953b1a2 -->

<!-- START_a2ce8a537aa3c2515cc299f6bbc9177f -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'https://domain.ltd/cms/sections/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/sections/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('PUT', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/sections/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT cms/sections/{section}`

`PATCH cms/sections/{section}`


<!-- END_a2ce8a537aa3c2515cc299f6bbc9177f -->

<!-- START_407964e31a186da6cf713cf898518de2 -->
## Remove the specified resource from storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/sections/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/sections/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/sections/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/sections/{section}`


<!-- END_407964e31a186da6cf713cf898518de2 -->

<!-- START_0cab549fa51482b1624e25b98dc7453a -->
## cms/sections/massDelete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/sections/massDelete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/sections/massDelete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/sections/massDelete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/sections/massDelete`


<!-- END_0cab549fa51482b1624e25b98dc7453a -->

<!-- START_b2fd53d87750557588a87986dafc3dde -->
## cms/sections/updateTree
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/sections/updateTree',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/sections/updateTree'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/sections/updateTree"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/sections/updateTree`


<!-- END_b2fd53d87750557588a87986dafc3dde -->

<!-- START_02c5548326656a6b23667941e5ab33fb -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/sections/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/sections/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/sections/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/sections/{sections}/update`


<!-- END_02c5548326656a6b23667941e5ab33fb -->

<!-- START_41108dc408219d26196deae38650e383 -->
## cms/sections/{sections}/undelete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/sections/1/undelete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/sections/1/undelete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/sections/1/undelete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/sections/{sections}/undelete`


<!-- END_41108dc408219d26196deae38650e383 -->

<!-- START_27e73b458485920448be1ae952b9afdd -->
## cms/sections/{sections}/destroyForever
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/sections/1/destroyForever',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/sections/1/destroyForever'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/sections/1/destroyForever"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/sections/{sections}/destroyForever`


<!-- END_27e73b458485920448be1ae952b9afdd -->

<!-- START_ec9a3d755926c70cba32d788b1692f59 -->
## Display a listing of the resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/section_users',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/section_users'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/section_users"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/section_users`


<!-- END_ec9a3d755926c70cba32d788b1692f59 -->

<!-- START_0c2d39c0560cabab03d4df783e039c34 -->
## Show the form for creating a new resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/section_users/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/section_users/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/section_users/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/section_users/create`


<!-- END_0c2d39c0560cabab03d4df783e039c34 -->

<!-- START_fbec3f41fd75e72c510b7c87f06a892b -->
## Store a newly created resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/section_users',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/section_users'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/section_users"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/section_users`


<!-- END_fbec3f41fd75e72c510b7c87f06a892b -->

<!-- START_23f4d854034a5274cb68441d24c3098d -->
## Display the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/section_users/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/section_users/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/section_users/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/section_users/{section_user}`


<!-- END_23f4d854034a5274cb68441d24c3098d -->

<!-- START_dec80ade6e6812572c6ee7e782dbe1af -->
## Show the form for editing the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/section_users/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/section_users/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/section_users/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/section_users/{section_user}/edit`


<!-- END_dec80ade6e6812572c6ee7e782dbe1af -->

<!-- START_eb615d510d2468d60fbf1a607f4b34fa -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'https://domain.ltd/cms/section_users/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/section_users/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('PUT', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/section_users/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT cms/section_users/{section_user}`

`PATCH cms/section_users/{section_user}`


<!-- END_eb615d510d2468d60fbf1a607f4b34fa -->

<!-- START_cc2f99faba9b0a7888423037013be391 -->
## Remove the specified resource from storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/section_users/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/section_users/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/section_users/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/section_users/{section_user}`


<!-- END_cc2f99faba9b0a7888423037013be391 -->

<!-- START_33a21f4ade5f68f0f3f7ae996c503df5 -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/section_users/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/section_users/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/section_users/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/section_users/{section_users}/update`


<!-- END_33a21f4ade5f68f0f3f7ae996c503df5 -->

<!-- START_922abf3e8c3065b02a4769ff2a546e87 -->
## Display a listing of the resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/articles',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/articles'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/articles"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/articles`


<!-- END_922abf3e8c3065b02a4769ff2a546e87 -->

<!-- START_75f7931af135fa7e7e17c4f4ff6e5e17 -->
## Show the form for creating a new resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/articles/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/articles/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/articles/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/articles/create`


<!-- END_75f7931af135fa7e7e17c4f4ff6e5e17 -->

<!-- START_e6ee1c3083b071af36fccb4fa4a6d7e3 -->
## Store a newly created resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/articles',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/articles'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/articles"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/articles`


<!-- END_e6ee1c3083b071af36fccb4fa4a6d7e3 -->

<!-- START_fb57171320a494a855855df8ff08b566 -->
## Display the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/articles/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/articles/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/articles/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/articles/{article}`


<!-- END_fb57171320a494a855855df8ff08b566 -->

<!-- START_bec4c63aca2279d796de1bc77b5986e8 -->
## Show the form for editing the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/articles/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/articles/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/articles/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/articles/{article}/edit`


<!-- END_bec4c63aca2279d796de1bc77b5986e8 -->

<!-- START_a15508bfa75c0ed9bee39a5d755a5182 -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'https://domain.ltd/cms/articles/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/articles/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('PUT', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/articles/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT cms/articles/{article}`

`PATCH cms/articles/{article}`


<!-- END_a15508bfa75c0ed9bee39a5d755a5182 -->

<!-- START_7322f36675f4f0e9b7f523ed1b7820b5 -->
## Remove the specified resource from storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/articles/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/articles/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/articles/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/articles/{article}`


<!-- END_7322f36675f4f0e9b7f523ed1b7820b5 -->

<!-- START_e34dfc8b6d4dc5ac6f803dfecb8fd634 -->
## cms/articles/{articles}/undelete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/articles/1/undelete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/articles/1/undelete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/articles/1/undelete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/articles/{articles}/undelete`


<!-- END_e34dfc8b6d4dc5ac6f803dfecb8fd634 -->

<!-- START_3ad2c287d8a55c7d9f6a29f738f0ec26 -->
## cms/articles/{articles}/destroyForever
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/articles/1/destroyForever',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/articles/1/destroyForever'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/articles/1/destroyForever"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/articles/{articles}/destroyForever`


<!-- END_3ad2c287d8a55c7d9f6a29f738f0ec26 -->

<!-- START_558c88de4b6420de4f6d792ea7ce9763 -->
## cms/articles/massDelete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/articles/massDelete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/articles/massDelete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/articles/massDelete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/articles/massDelete`


<!-- END_558c88de4b6420de4f6d792ea7ce9763 -->

<!-- START_50f721bb9e2c3f6a8d16cbd319c3fcf1 -->
## cms/articles/restore
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/articles/restore',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/articles/restore'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/articles/restore"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/articles/restore`


<!-- END_50f721bb9e2c3f6a8d16cbd319c3fcf1 -->

<!-- START_c231448a700eb4e3867e81234fc59b43 -->
## cms/articles/massUpdateAuthor
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/articles/massUpdateAuthor',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/articles/massUpdateAuthor'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/articles/massUpdateAuthor"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/articles/massUpdateAuthor`


<!-- END_c231448a700eb4e3867e81234fc59b43 -->

<!-- START_4c494148a23a4b9a185429f115296ede -->
## cms/articles/changeSection
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/articles/changeSection',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/articles/changeSection'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/articles/changeSection"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/articles/changeSection`


<!-- END_4c494148a23a4b9a185429f115296ede -->

<!-- START_0a08746f6ded1b0836ea14b21776755f -->
## cms/articles/searchAuthor
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/articles/searchAuthor',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/articles/searchAuthor'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/articles/searchAuthor"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/articles/searchAuthor`


<!-- END_0a08746f6ded1b0836ea14b21776755f -->

<!-- START_4c3ef34632f211a56dbbe2d93b0975a0 -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/articles/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/articles/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/articles/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/articles/{articles}/update`


<!-- END_4c3ef34632f211a56dbbe2d93b0975a0 -->

<!-- START_7d6964daf10eeea4e43f9ceab78dd383 -->
## Display a listing of the resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/comments',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/comments'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/comments"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/comments`


<!-- END_7d6964daf10eeea4e43f9ceab78dd383 -->

<!-- START_faaf2c183a7d43d241836691b1899746 -->
## Display the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/comments/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/comments/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/comments/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/comments/{comment}`


<!-- END_faaf2c183a7d43d241836691b1899746 -->

<!-- START_c1bd772438d8850bb98124703d18ec91 -->
## Show the form for editing the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/comments/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/comments/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/comments/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/comments/{comment}/edit`


<!-- END_c1bd772438d8850bb98124703d18ec91 -->

<!-- START_783b9606f391a434112ca80429dc3d07 -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'https://domain.ltd/cms/comments/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/comments/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('PUT', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/comments/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT cms/comments/{comment}`

`PATCH cms/comments/{comment}`


<!-- END_783b9606f391a434112ca80429dc3d07 -->

<!-- START_89e5848d7d217ec4d553587a359b505d -->
## Remove the specified resource from storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/comments/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/comments/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/comments/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/comments/{comment}`


<!-- END_89e5848d7d217ec4d553587a359b505d -->

<!-- START_6d5297ad30444b336f04b3f263870857 -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/comments/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/comments/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/comments/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/comments/{comments}/update`


<!-- END_6d5297ad30444b336f04b3f263870857 -->

<!-- START_404041460c552c75852091c9b4ff6aef -->
## Display a listing of the resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/pool',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/pool'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/pool"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/pool`


<!-- END_404041460c552c75852091c9b4ff6aef -->

<!-- START_40a1699da56977b9ec4779d273817815 -->
## cms/pool/approve_complain/{id}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/pool/approve_complain/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/pool/approve_complain/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/pool/approve_complain/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/pool/approve_complain/{id}`


<!-- END_40a1699da56977b9ec4779d273817815 -->

<!-- START_464679b2e768545dbd76d82c3e792804 -->
## cms/pool/deny_complain/{id}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/pool/deny_complain/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/pool/deny_complain/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/pool/deny_complain/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/pool/deny_complain/{id}`


<!-- END_464679b2e768545dbd76d82c3e792804 -->

<!-- START_a24d13780db8da95276d10c3de158d72 -->
## cms/pool/approve/{object}/{id}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/pool/approve/1/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/pool/approve/1/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/pool/approve/1/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/pool/approve/{object}/{id}`

`POST cms/pool/approve/{object}/{id}`

`PUT cms/pool/approve/{object}/{id}`

`PATCH cms/pool/approve/{object}/{id}`

`DELETE cms/pool/approve/{object}/{id}`

`OPTIONS cms/pool/approve/{object}/{id}`


<!-- END_a24d13780db8da95276d10c3de158d72 -->

<!-- START_ef1d08fa183d6a6758f9514c59622399 -->
## cms/pool/deny_section_transfer/{id}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/pool/deny_section_transfer/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/pool/deny_section_transfer/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/pool/deny_section_transfer/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/pool/deny_section_transfer/{id}`

`POST cms/pool/deny_section_transfer/{id}`

`PUT cms/pool/deny_section_transfer/{id}`

`PATCH cms/pool/deny_section_transfer/{id}`

`DELETE cms/pool/deny_section_transfer/{id}`

`OPTIONS cms/pool/deny_section_transfer/{id}`


<!-- END_ef1d08fa183d6a6758f9514c59622399 -->

<!-- START_964640aae239d1ecce9b11f0ddbd4125 -->
## cms/pool/approve_section_transfer/{id}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/pool/approve_section_transfer/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/pool/approve_section_transfer/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/pool/approve_section_transfer/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/pool/approve_section_transfer/{id}`

`POST cms/pool/approve_section_transfer/{id}`

`PUT cms/pool/approve_section_transfer/{id}`

`PATCH cms/pool/approve_section_transfer/{id}`

`DELETE cms/pool/approve_section_transfer/{id}`

`OPTIONS cms/pool/approve_section_transfer/{id}`


<!-- END_964640aae239d1ecce9b11f0ddbd4125 -->

<!-- START_9e51fc4f85d1bb922a56d70814b9216a -->
## cms/pool/delete/{object}/{id}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/pool/delete/1/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/pool/delete/1/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/pool/delete/1/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/pool/delete/{object}/{id}`


<!-- END_9e51fc4f85d1bb922a56d70814b9216a -->

<!-- START_b5ca24335336fab39a6d4ad63437064c -->
## Display a listing of the resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/complain_options',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/complain_options'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/complain_options"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/complain_options`


<!-- END_b5ca24335336fab39a6d4ad63437064c -->

<!-- START_17b239e968a7f5ceff90add17337fe94 -->
## Show the form for creating a new resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/complain_options/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/complain_options/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/complain_options/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/complain_options/create`


<!-- END_17b239e968a7f5ceff90add17337fe94 -->

<!-- START_aabd7d1d858f5e32cb063c5df9ec3aa7 -->
## Store a newly created resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/complain_options',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/complain_options'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/complain_options"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/complain_options`


<!-- END_aabd7d1d858f5e32cb063c5df9ec3aa7 -->

<!-- START_2bac7a808dee5cf16d8c93f6c571c9a1 -->
## Show the form for editing the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/complain_options/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/complain_options/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/complain_options/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/complain_options/{complain_option}/edit`


<!-- END_2bac7a808dee5cf16d8c93f6c571c9a1 -->

<!-- START_a590ee7f40f651793e5f9f7f3e765193 -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'https://domain.ltd/cms/complain_options/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/complain_options/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('PUT', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/complain_options/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT cms/complain_options/{complain_option}`

`PATCH cms/complain_options/{complain_option}`


<!-- END_a590ee7f40f651793e5f9f7f3e765193 -->

<!-- START_9fefec2f5cfc5d7fbe54775af0fa6d9b -->
## Remove the specified resource from storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/complain_options/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/complain_options/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/complain_options/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/complain_options/{complain_option}`


<!-- END_9fefec2f5cfc5d7fbe54775af0fa6d9b -->

<!-- START_f296fe5dab4a449bad8973c5dacb7329 -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/complain_options/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/complain_options/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/complain_options/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/complain_options/{complain_options}/update`


<!-- END_f296fe5dab4a449bad8973c5dacb7329 -->

<!-- START_0580b53f0b5ef2d441a4176d0c0f98ae -->
## cms/complain_options/updateTree
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/complain_options/updateTree',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/complain_options/updateTree'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/complain_options/updateTree"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/complain_options/updateTree`


<!-- END_0580b53f0b5ef2d441a4176d0c0f98ae -->

<!-- START_05885ba0cb5f460c25f68fed58de1f58 -->
## Display a listing of the resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/complains',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/complains'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/complains"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/complains`


<!-- END_05885ba0cb5f460c25f68fed58de1f58 -->

<!-- START_fceb51f0e81b5664286df23bd17eb531 -->
## Show the form for creating a new resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/complains/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/complains/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/complains/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/complains/create`


<!-- END_fceb51f0e81b5664286df23bd17eb531 -->

<!-- START_d99a112760901a9effde4da0824c605f -->
## Store a newly created resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/complains',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/complains'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/complains"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/complains`


<!-- END_d99a112760901a9effde4da0824c605f -->

<!-- START_d08ac7ade29b7ef96abec0c5463ba334 -->
## Display the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/complains/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/complains/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/complains/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/complains/{complain}`


<!-- END_d08ac7ade29b7ef96abec0c5463ba334 -->

<!-- START_a4d6ef68fd03b65a0925ce02f0af4e3f -->
## Show the form for editing the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/complains/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/complains/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/complains/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/complains/{complain}/edit`


<!-- END_a4d6ef68fd03b65a0925ce02f0af4e3f -->

<!-- START_5b6a98d2dac3cacdd3bd66bd6212bdb5 -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'https://domain.ltd/cms/complains/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/complains/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('PUT', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/complains/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT cms/complains/{complain}`

`PATCH cms/complains/{complain}`


<!-- END_5b6a98d2dac3cacdd3bd66bd6212bdb5 -->

<!-- START_9d11e7253384b6af2b9a63422d53eb6b -->
## Remove the specified resource from storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/complains/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/complains/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/complains/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/complains/{complain}`


<!-- END_9d11e7253384b6af2b9a63422d53eb6b -->

<!-- START_8840ac800f4fdbdd9bdf9000bcebb546 -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/complains/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/complains/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/complains/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/complains/{complains}/update`


<!-- END_8840ac800f4fdbdd9bdf9000bcebb546 -->

<!-- START_beed59f6a24624d03397fd580572ce59 -->
## Display a listing of the resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/thematic',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/thematic'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/thematic"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/thematic`


<!-- END_beed59f6a24624d03397fd580572ce59 -->

<!-- START_93427fb353fbac29865864bddb4ed2e3 -->
## Show the form for creating a new resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/thematic/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/thematic/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/thematic/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/thematic/create`


<!-- END_93427fb353fbac29865864bddb4ed2e3 -->

<!-- START_b912a8c0a61d9af58f835cfb7b9b7ce0 -->
## Store a newly created resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/thematic',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/thematic'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/thematic"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/thematic`


<!-- END_b912a8c0a61d9af58f835cfb7b9b7ce0 -->

<!-- START_6e2dae0a87807b23faf0112186d9d998 -->
## Display the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/thematic/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/thematic/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/thematic/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/thematic/{thematic}`


<!-- END_6e2dae0a87807b23faf0112186d9d998 -->

<!-- START_4badc052ca568a4ea1623b52df41fda1 -->
## Show the form for editing the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/thematic/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/thematic/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/thematic/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/thematic/{thematic}/edit`


<!-- END_4badc052ca568a4ea1623b52df41fda1 -->

<!-- START_ac59fc8a678925929fbf8f8281e05eb2 -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'https://domain.ltd/cms/thematic/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/thematic/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('PUT', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/thematic/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT cms/thematic/{thematic}`

`PATCH cms/thematic/{thematic}`


<!-- END_ac59fc8a678925929fbf8f8281e05eb2 -->

<!-- START_1df167d3d22ce7f2a3647ab925f9b36d -->
## Remove the specified resource from storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/thematic/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/thematic/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/thematic/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/thematic/{thematic}`


<!-- END_1df167d3d22ce7f2a3647ab925f9b36d -->

<!-- START_3d84699c5f33843a320e9b4413262cd6 -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/thematic/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/thematic/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/thematic/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/thematic/{thematic}/update`


<!-- END_3d84699c5f33843a320e9b4413262cd6 -->

<!-- START_f201c059b1cd8c32771defba6f017578 -->
## Display a listing of the resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/language',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/language'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/language"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/language`


<!-- END_f201c059b1cd8c32771defba6f017578 -->

<!-- START_8ee2adefce4d2e401d49698977821ec6 -->
## Show the form for creating a new resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/language/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/language/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/language/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/language/create`


<!-- END_8ee2adefce4d2e401d49698977821ec6 -->

<!-- START_d5f0d0356596c42e4996654dffabff2d -->
## Store a newly created resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/language',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/language'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/language"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/language`


<!-- END_d5f0d0356596c42e4996654dffabff2d -->

<!-- START_f22aef862e3494dbf7357a02c7e1ae5b -->
## Display the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/language/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/language/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/language/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/language/{language}`


<!-- END_f22aef862e3494dbf7357a02c7e1ae5b -->

<!-- START_2867f1a790d5a3faefeae397419ced48 -->
## Show the form for editing the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/language/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/language/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/language/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/language/{language}/edit`


<!-- END_2867f1a790d5a3faefeae397419ced48 -->

<!-- START_678b53999288cf1aedf8a6f89fb3ee89 -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'https://domain.ltd/cms/language/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/language/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('PUT', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/language/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT cms/language/{language}`

`PATCH cms/language/{language}`


<!-- END_678b53999288cf1aedf8a6f89fb3ee89 -->

<!-- START_372233cd9862018598ac078c703cffc5 -->
## Remove the specified resource from storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/language/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/language/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/language/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/language/{language}`


<!-- END_372233cd9862018598ac078c703cffc5 -->

<!-- START_a7984799edd62d35aa45cc4e1b3ef4dd -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/language/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/language/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/language/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/language/{language}/update`


<!-- END_a7984799edd62d35aa45cc4e1b3ef4dd -->

<!-- START_e3ec6ba8c9520d074bce0d7c4dbb126c -->
## cms/objects/relations
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/objects/relations',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/objects/relations'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/objects/relations"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/objects/relations`


<!-- END_e3ec6ba8c9520d074bce0d7c4dbb126c -->

<!-- START_916e40a7ef049772744635f9cbbc2277 -->
## Display a listing of the resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/objects',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/objects'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/objects"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/objects`


<!-- END_916e40a7ef049772744635f9cbbc2277 -->

<!-- START_99a27210a34e2a5cf7647a9b629ab6ce -->
## Show the form for creating a new resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/objects/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/objects/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/objects/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/objects/create`


<!-- END_99a27210a34e2a5cf7647a9b629ab6ce -->

<!-- START_5abc4a3b993eecc479f52ea0c7a833b7 -->
## Store a newly created resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/objects',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/objects'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/objects"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/objects`


<!-- END_5abc4a3b993eecc479f52ea0c7a833b7 -->

<!-- START_359e86a155d1f64c07f8fdd01488df67 -->
## Display the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/objects/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/objects/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/objects/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/objects/{object}`


<!-- END_359e86a155d1f64c07f8fdd01488df67 -->

<!-- START_c73491ff79c7a98731da772cf36ba68c -->
## Show the form for editing the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/objects/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/objects/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/objects/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/objects/{object}/edit`


<!-- END_c73491ff79c7a98731da772cf36ba68c -->

<!-- START_111ad7b32926e34866fa19c3296fa5b3 -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'https://domain.ltd/cms/objects/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/objects/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('PUT', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/objects/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT cms/objects/{object}`

`PATCH cms/objects/{object}`


<!-- END_111ad7b32926e34866fa19c3296fa5b3 -->

<!-- START_8366e6596c6482707f6b03452a3c30a7 -->
## Remove the specified resource from storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/objects/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/objects/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/objects/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/objects/{object}`


<!-- END_8366e6596c6482707f6b03452a3c30a7 -->

<!-- START_d13041af5c2a5af3bca54f4d1ff3c907 -->
## cms/objects/massDelete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/objects/massDelete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/objects/massDelete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/objects/massDelete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/objects/massDelete`


<!-- END_d13041af5c2a5af3bca54f4d1ff3c907 -->

<!-- START_471c854b0b069cf22c76609916a0acb5 -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/objects/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/objects/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/objects/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/objects/{objects}/update`


<!-- END_471c854b0b069cf22c76609916a0acb5 -->

<!-- START_9b8eed075e8158b753cca6e8415629ed -->
## cms/objects/updateNode
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/objects/updateNode',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/objects/updateNode'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/objects/updateNode"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/objects/updateNode`


<!-- END_9b8eed075e8158b753cca6e8415629ed -->

<!-- START_335ef9ebdb6195602005662b962ad015 -->
## Display a listing of the resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/object_fields',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/object_fields'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/object_fields"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/object_fields`


<!-- END_335ef9ebdb6195602005662b962ad015 -->

<!-- START_d3ba87418f53785831e9749e3bd84424 -->
## Show the form for creating a new resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/object_fields/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/object_fields/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/object_fields/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/object_fields/create`


<!-- END_d3ba87418f53785831e9749e3bd84424 -->

<!-- START_4c8e1f8bca95977df09ea1cbdd8a507b -->
## Store a newly created resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/object_fields',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/object_fields'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/object_fields"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/object_fields`


<!-- END_4c8e1f8bca95977df09ea1cbdd8a507b -->

<!-- START_90442a92f68769201f9d29fbc3673045 -->
## Display the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/object_fields/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/object_fields/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/object_fields/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/object_fields/{object_field}`


<!-- END_90442a92f68769201f9d29fbc3673045 -->

<!-- START_b667c30736025f8fc6854bd234a67196 -->
## Show the form for editing the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/object_fields/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/object_fields/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/object_fields/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/object_fields/{object_field}/edit`


<!-- END_b667c30736025f8fc6854bd234a67196 -->

<!-- START_38b6557710acc51bbb70ed0b7bb7494f -->
## cms/object_fields/{object_field}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'https://domain.ltd/cms/object_fields/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/object_fields/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('PUT', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/object_fields/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT cms/object_fields/{object_field}`

`PATCH cms/object_fields/{object_field}`


<!-- END_38b6557710acc51bbb70ed0b7bb7494f -->

<!-- START_a163fdfd5c4605aa90e7164736e1894d -->
## cms/object_fields/{object_field}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/object_fields/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/object_fields/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/object_fields/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/object_fields/{object_field}`


<!-- END_a163fdfd5c4605aa90e7164736e1894d -->

<!-- START_274e2a5d9037b76174144b11c209d631 -->
## cms/object_fields/{object_fields}/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/object_fields/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/object_fields/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/object_fields/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/object_fields/{object_fields}/update`


<!-- END_274e2a5d9037b76174144b11c209d631 -->

<!-- START_928a381d2b74690cde93a4d0db590821 -->
## Display a listing of the resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/object_fields_relations',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/object_fields_relations'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/object_fields_relations"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/object_fields_relations`


<!-- END_928a381d2b74690cde93a4d0db590821 -->

<!-- START_ef3b0b73d3dfbd6cb575934f0e0fcab7 -->
## Show the form for creating a new resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/object_fields_relations/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/object_fields_relations/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/object_fields_relations/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/object_fields_relations/create`


<!-- END_ef3b0b73d3dfbd6cb575934f0e0fcab7 -->

<!-- START_c13b76e7d97d3eda1ae46ffc6705e284 -->
## Store a newly created resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/object_fields_relations',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/object_fields_relations'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/object_fields_relations"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/object_fields_relations`


<!-- END_c13b76e7d97d3eda1ae46ffc6705e284 -->

<!-- START_f76097a8563a669a9cf7ddf06cacc9d9 -->
## cms/object_fields_relations/{object_fields_relation}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/object_fields_relations/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/object_fields_relations/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/object_fields_relations/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/object_fields_relations/{object_fields_relation}`


<!-- END_f76097a8563a669a9cf7ddf06cacc9d9 -->

<!-- START_029505665b08acffa2e0b48e2dbb10b7 -->
## Display a listing of the resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/object_field_groups',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/object_field_groups'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/object_field_groups"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/object_field_groups`


<!-- END_029505665b08acffa2e0b48e2dbb10b7 -->

<!-- START_092f468b67251ebde4fe45475e5469d4 -->
## Show the form for creating a new resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/object_field_groups/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/object_field_groups/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/object_field_groups/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/object_field_groups/create`


<!-- END_092f468b67251ebde4fe45475e5469d4 -->

<!-- START_5a05c1c57918d4a5d305b92912aa4952 -->
## Store a newly created resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/object_field_groups',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/object_field_groups'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/object_field_groups"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/object_field_groups`


<!-- END_5a05c1c57918d4a5d305b92912aa4952 -->

<!-- START_fb7c9990593b74ffb1dbe050644d2967 -->
## Display the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/object_field_groups/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/object_field_groups/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/object_field_groups/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/object_field_groups/{object_field_group}`


<!-- END_fb7c9990593b74ffb1dbe050644d2967 -->

<!-- START_3ad37618a707e7b1e84a9a3b0a7155e0 -->
## Show the form for editing the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/object_field_groups/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/object_field_groups/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/object_field_groups/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/object_field_groups/{object_field_group}/edit`


<!-- END_3ad37618a707e7b1e84a9a3b0a7155e0 -->

<!-- START_ca2c6a4708f2949267bcfb0e1de554c8 -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'https://domain.ltd/cms/object_field_groups/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/object_field_groups/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('PUT', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/object_field_groups/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT cms/object_field_groups/{object_field_group}`

`PATCH cms/object_field_groups/{object_field_group}`


<!-- END_ca2c6a4708f2949267bcfb0e1de554c8 -->

<!-- START_01930f08fa44148ecb157f973532f413 -->
## Remove the specified resource from storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/object_field_groups/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/object_field_groups/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/object_field_groups/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/object_field_groups/{object_field_group}`


<!-- END_01930f08fa44148ecb157f973532f413 -->

<!-- START_5d449012eef74d4a116fd6423c4bc1db -->
## cms/object_field_groups/updateTree
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/object_field_groups/updateTree',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/object_field_groups/updateTree'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/object_field_groups/updateTree"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/object_field_groups/updateTree`


<!-- END_5d449012eef74d4a116fd6423c4bc1db -->

<!-- START_d144b4f0113fb2274a876cb489bc84aa -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/object_field_groups/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/object_field_groups/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/object_field_groups/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/object_field_groups/{object_field_groups}/update`


<!-- END_d144b4f0113fb2274a876cb489bc84aa -->

<!-- START_0c38c38fd3d70f0dd4a32f9a75c5e1d2 -->
## cms/subscriptions
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/subscriptions',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/subscriptions'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/subscriptions"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/subscriptions`


<!-- END_0c38c38fd3d70f0dd4a32f9a75c5e1d2 -->

<!-- START_46b034b329a65ac18963ba3b2b94c9b2 -->
## cms/subscriptions/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/subscriptions/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/subscriptions/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/subscriptions/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/subscriptions/create`


<!-- END_46b034b329a65ac18963ba3b2b94c9b2 -->

<!-- START_154027139c31184af968cbb42fd1530c -->
## cms/subscriptions
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/subscriptions',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/subscriptions'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/subscriptions"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/subscriptions`


<!-- END_154027139c31184af968cbb42fd1530c -->

<!-- START_eee747dae94f697dcd51bfef025411c0 -->
## cms/subscriptions/{subscription}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/subscriptions/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/subscriptions/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/subscriptions/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/subscriptions/{subscription}`


<!-- END_eee747dae94f697dcd51bfef025411c0 -->

<!-- START_0f0167c99126f85088bffb9a63e7b4b5 -->
## cms/subscriptions/{subscription}/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/subscriptions/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/subscriptions/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/subscriptions/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/subscriptions/{subscription}/edit`


<!-- END_0f0167c99126f85088bffb9a63e7b4b5 -->

<!-- START_83d8a9e0338c86eb24b804db0141e6c4 -->
## cms/subscriptions/{subscription}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'https://domain.ltd/cms/subscriptions/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/subscriptions/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('PUT', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/subscriptions/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT cms/subscriptions/{subscription}`

`PATCH cms/subscriptions/{subscription}`


<!-- END_83d8a9e0338c86eb24b804db0141e6c4 -->

<!-- START_6c654e2a9803512f0204addb3818c725 -->
## cms/subscriptions/{subscription}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/subscriptions/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/subscriptions/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/subscriptions/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/subscriptions/{subscription}`


<!-- END_6c654e2a9803512f0204addb3818c725 -->

<!-- START_e7e5970790bd0e003ebd44ffffe0bdf1 -->
## cms/subscriptions/{subscriptions}/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/subscriptions/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/subscriptions/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/subscriptions/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/subscriptions/{subscriptions}/update`


<!-- END_e7e5970790bd0e003ebd44ffffe0bdf1 -->

<!-- START_9c0b04a176eacd772c86578a38a6ecfc -->
## cms/subscriptions/{subscriptions}/undelete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/subscriptions/1/undelete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/subscriptions/1/undelete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/subscriptions/1/undelete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/subscriptions/{subscriptions}/undelete`


<!-- END_9c0b04a176eacd772c86578a38a6ecfc -->

<!-- START_5e21386f6652a3431679c1b21ffdb8e9 -->
## cms/subscriptions/{subscriptions}/destroyForever
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/subscriptions/1/destroyForever',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/subscriptions/1/destroyForever'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/subscriptions/1/destroyForever"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/subscriptions/{subscriptions}/destroyForever`


<!-- END_5e21386f6652a3431679c1b21ffdb8e9 -->

<!-- START_b8e2c1576d2bb3c19c30a5f797fa30b6 -->
## Display a listing of the resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/activities',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/activities'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/activities"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/activities`


<!-- END_b8e2c1576d2bb3c19c30a5f797fa30b6 -->

<!-- START_9f960aa78d1e9438b4b0ec2db8270874 -->
## Display the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/activities/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/activities/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/activities/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/activities/{activity}`


<!-- END_9f960aa78d1e9438b4b0ec2db8270874 -->

<!-- START_e6b57b063945278221afa0bff21fa641 -->
## cms/activities/searchAuthor
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/activities/searchAuthor',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/activities/searchAuthor'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/activities/searchAuthor"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/activities/searchAuthor`


<!-- END_e6b57b063945278221afa0bff21fa641 -->

<!-- START_bc3bd4bc2f0df538c161bccf2040f94a -->
## Display a listing of the resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/activity_languages',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/activity_languages'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/activity_languages"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/activity_languages`


<!-- END_bc3bd4bc2f0df538c161bccf2040f94a -->

<!-- START_2f2515c9a0b46ae75291832e438064f6 -->
## Display the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/activity_languages/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/activity_languages/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/activity_languages/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/activity_languages/{activity_language}`


<!-- END_2f2515c9a0b46ae75291832e438064f6 -->

<!-- START_444068e35d1786c97f81a56aefb8b5bf -->
## cms/activity_languages/{activity_language}/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/activity_languages/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/activity_languages/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/activity_languages/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/activity_languages/{activity_language}/edit`


<!-- END_444068e35d1786c97f81a56aefb8b5bf -->

<!-- START_f48ee59c55770069d0f474458acc6064 -->
## cms/activity_languages/{activity_language}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'https://domain.ltd/cms/activity_languages/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/activity_languages/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('PUT', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/activity_languages/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT cms/activity_languages/{activity_language}`

`PATCH cms/activity_languages/{activity_language}`


<!-- END_f48ee59c55770069d0f474458acc6064 -->

<!-- START_219386340fde49eda79fba89fdbf93e7 -->
## cms/activity_languages/{activity_languages}/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/activity_languages/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/activity_languages/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/activity_languages/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/activity_languages/{activity_languages}/update`


<!-- END_219386340fde49eda79fba89fdbf93e7 -->

<!-- START_9156045fd4364b659619ff382e041244 -->
## Display a listing of the resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/currency',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/currency'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/currency"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/currency`


<!-- END_9156045fd4364b659619ff382e041244 -->

<!-- START_e6f4dbdaaceffb16c2844761a0ea40ae -->
## cms/currency/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/currency/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/currency/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/currency/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/currency/create`


<!-- END_e6f4dbdaaceffb16c2844761a0ea40ae -->

<!-- START_cdb505b7254b21f0902de8c5aeef6e19 -->
## cms/currency
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/currency',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/currency'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/currency"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/currency`


<!-- END_cdb505b7254b21f0902de8c5aeef6e19 -->

<!-- START_feb8ad8cc6bdac828d0c16305199df19 -->
## Display the specified resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/currency/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/currency/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/currency/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/currency/{currency}`


<!-- END_feb8ad8cc6bdac828d0c16305199df19 -->

<!-- START_512a096c1b3bd53caf7263a6383b8eb2 -->
## cms/currency/{currency}/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/currency/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/currency/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/currency/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/currency/{currency}/edit`


<!-- END_512a096c1b3bd53caf7263a6383b8eb2 -->

<!-- START_9ff7da33f266e400de3aa4bbfc8c692b -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'https://domain.ltd/cms/currency/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/currency/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('PUT', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/currency/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT cms/currency/{currency}`

`PATCH cms/currency/{currency}`


<!-- END_9ff7da33f266e400de3aa4bbfc8c692b -->

<!-- START_8da289a5b869f90cbf042a1f9021572c -->
## cms/currency/{currency}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/currency/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/currency/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/currency/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/currency/{currency}`


<!-- END_8da289a5b869f90cbf042a1f9021572c -->

<!-- START_0ca12f3b63a7a5b954600b10211f34ce -->
## Update the specified resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/currency/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/currency/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/currency/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/currency/{currency}/update`


<!-- END_0ca12f3b63a7a5b954600b10211f34ce -->

<!-- START_d360295ed001a255102edadf63cb7fa1 -->
## cms/service_options
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/service_options',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/service_options'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/service_options"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/service_options`


<!-- END_d360295ed001a255102edadf63cb7fa1 -->

<!-- START_cc1c58fb531724dc7127aac19ffc1fc1 -->
## cms/service_options/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/service_options/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/service_options/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/service_options/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/service_options/create`


<!-- END_cc1c58fb531724dc7127aac19ffc1fc1 -->

<!-- START_272e077501abfc881241b8d9d47af5ea -->
## cms/service_options/store
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/service_options/store',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/service_options/store'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/service_options/store"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/service_options/store`


<!-- END_272e077501abfc881241b8d9d47af5ea -->

<!-- START_d530c7ecebee0dffac3b33a3573c3aed -->
## cms/service_options/{service_options}/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/service_options/1/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/service_options/1/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/service_options/1/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cms/service_options/{service_options}/edit`


<!-- END_d530c7ecebee0dffac3b33a3573c3aed -->

<!-- START_d2dfce9b39e7e93e7f5ad5035e6d258b -->
## cms/service_options/{service_options}/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/service_options/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/service_options/1/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/service_options/1/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/service_options/{service_options}/update`


<!-- END_d2dfce9b39e7e93e7f5ad5035e6d258b -->

<!-- START_071b1ec48681e68a33f39a5f1c3b2fa7 -->
## cms/service_options/{service_options}/destroy
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://domain.ltd/cms/service_options/1/destroy',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/service_options/1/destroy'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/service_options/1/destroy"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE cms/service_options/{service_options}/destroy`


<!-- END_071b1ec48681e68a33f39a5f1c3b2fa7 -->

<!-- START_ca4a77bd3dbd2826ae35b7473b320cf6 -->
## cms/login
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cms/login',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/login'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/login"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
null
```

### HTTP Request
`GET cms/login`


<!-- END_ca4a77bd3dbd2826ae35b7473b320cf6 -->

<!-- START_93f9e524041aeb41ea84fb8a17922ba2 -->
## cms/login/auth
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/cms/login/auth',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cms/login/auth'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cms/login/auth"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST cms/login/auth`


<!-- END_93f9e524041aeb41ea84fb8a17922ba2 -->

<!-- START_fae7af41cb8b74c7ec3311dbbfa7ca92 -->
## social/vk
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/social/vk',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/social/vk'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/social/vk"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET social/vk`


<!-- END_fae7af41cb8b74c7ec3311dbbfa7ca92 -->

<!-- START_4ecd16f78a69a145769176ec68804bc5 -->
## social/vk/callback
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/social/vk/callback',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/social/vk/callback'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/social/vk/callback"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
null
```

### HTTP Request
`GET social/vk/callback`


<!-- END_4ecd16f78a69a145769176ec68804bc5 -->

<!-- START_409f991b95ab4ba6c99e37117d17dbc2 -->
## social/google
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/social/google',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/social/google'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/social/google"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET social/google`


<!-- END_409f991b95ab4ba6c99e37117d17dbc2 -->

<!-- START_8e3c52d0426c62107f95766f28b9f43c -->
## social/google/callback
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/social/google/callback',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/social/google/callback'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/social/google/callback"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
null
```

### HTTP Request
`GET social/google/callback`


<!-- END_8e3c52d0426c62107f95766f28b9f43c -->

<!-- START_fa515e2b4b3ddaecb4157aeaca3f30a2 -->
## social/ok
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/social/ok',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/social/ok'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/social/ok"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET social/ok`


<!-- END_fa515e2b4b3ddaecb4157aeaca3f30a2 -->

<!-- START_50f8c691a1e2817eac4495ca36783a2c -->
## social/ok/callback
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/social/ok/callback',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/social/ok/callback'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/social/ok/callback"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
null
```

### HTTP Request
`GET social/ok/callback`


<!-- END_50f8c691a1e2817eac4495ca36783a2c -->

<!-- START_5aa0196027a32c3353cf195be9d64365 -->
## social/twitter
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/social/twitter',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/social/twitter'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/social/twitter"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
null
```

### HTTP Request
`GET social/twitter`


<!-- END_5aa0196027a32c3353cf195be9d64365 -->

<!-- START_39a2bf0faf145fba66ae313797103241 -->
## social/twitter/callback
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/social/twitter/callback',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/social/twitter/callback'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/social/twitter/callback"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
null
```

### HTTP Request
`GET social/twitter/callback`


<!-- END_39a2bf0faf145fba66ae313797103241 -->

<!-- START_e9daa5ce090aa1cb3f999ef20679a9f0 -->
## social/instagram
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/social/instagram',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/social/instagram'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/social/instagram"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET social/instagram`


<!-- END_e9daa5ce090aa1cb3f999ef20679a9f0 -->

<!-- START_decb56caf40bf9fa65924ee7c5ae3f70 -->
## social/instagram/callback
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/social/instagram/callback',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/social/instagram/callback'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/social/instagram/callback"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
null
```

### HTTP Request
`GET social/instagram/callback`


<!-- END_decb56caf40bf9fa65924ee7c5ae3f70 -->

<!-- START_d1f01d86f6d2c1b35ab8f6b56e4b0478 -->
## social/yandex
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/social/yandex',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/social/yandex'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/social/yandex"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET social/yandex`


<!-- END_d1f01d86f6d2c1b35ab8f6b56e4b0478 -->

<!-- START_7e15d5800f47d6615d140c4f3ab0f574 -->
## social/yandex/callback
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/social/yandex/callback',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/social/yandex/callback'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/social/yandex/callback"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
null
```

### HTTP Request
`GET social/yandex/callback`


<!-- END_7e15d5800f47d6615d140c4f3ab0f574 -->

<!-- START_c8e98451851d7ae5582af559e39ae9f5 -->
## social/linkedin
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/social/linkedin',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/social/linkedin'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/social/linkedin"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
null
```

### HTTP Request
`GET social/linkedin`


<!-- END_c8e98451851d7ae5582af559e39ae9f5 -->

<!-- START_fcacf5bdfa42b82bc2d9d4748af0470d -->
## social/linkedin/callback
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/social/linkedin/callback',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/social/linkedin/callback'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/social/linkedin/callback"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
null
```

### HTTP Request
`GET social/linkedin/callback`


<!-- END_fcacf5bdfa42b82bc2d9d4748af0470d -->

<!-- START_3c0281f61120ff0976207fb2b9b4ac20 -->
## social/mailru
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/social/mailru',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/social/mailru'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/social/mailru"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET social/mailru`


<!-- END_3c0281f61120ff0976207fb2b9b4ac20 -->

<!-- START_7068d35dd24b322e798d8116eb5c4c93 -->
## social/mailru/callback
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/social/mailru/callback',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/social/mailru/callback'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/social/mailru/callback"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
null
```

### HTTP Request
`GET social/mailru/callback`


<!-- END_7068d35dd24b322e798d8116eb5c4c93 -->

<!-- START_bf9fbfb77a3c366ab7f7e9a43eb8949c -->
## social/facebook
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/social/facebook',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/social/facebook'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/social/facebook"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET social/facebook`


<!-- END_bf9fbfb77a3c366ab7f7e9a43eb8949c -->

<!-- START_eb7b1a0194a49b4613900f36ee8a9f47 -->
## social/facebook/callback
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/social/facebook/callback',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/social/facebook/callback'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/social/facebook/callback"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET social/facebook/callback`


<!-- END_eb7b1a0194a49b4613900f36ee8a9f47 -->

<!-- START_30f1bdcd6c2c17f678f758e41523675d -->
## sales/{id}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/sales/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/sales/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/sales/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
null
```

### HTTP Request
`GET sales/{id}`


<!-- END_30f1bdcd6c2c17f678f758e41523675d -->

<!-- START_e40bc60a458a9740730202aaec04f818 -->
## admin
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/admin',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/admin'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/admin"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
null
```

### HTTP Request
`GET admin`


<!-- END_e40bc60a458a9740730202aaec04f818 -->

<!-- START_0408a60c9fc78d92daf5482d9820aa6a -->
## api/export/site
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/export/site',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/export/site'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/export/site"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/export/site`


<!-- END_0408a60c9fc78d92daf5482d9820aa6a -->

<!-- START_169f3a6895b75c9a6edd693d40b6ec17 -->
## api/import/site
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/import/site',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/import/site'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/import/site"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/import/site`


<!-- END_169f3a6895b75c9a6edd693d40b6ec17 -->

<!-- START_638c3cc2744ee95a980e6b1e163a7487 -->
## sections
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/sections',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/sections'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/sections"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET sections`


<!-- END_638c3cc2744ee95a980e6b1e163a7487 -->

<!-- START_9371533281626b3219493e0791745eab -->
## section/{section}-{id}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/section/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/section/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/section/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
null
```

### HTTP Request
`GET section/{section}-{id}`


<!-- END_9371533281626b3219493e0791745eab -->

<!-- START_8f0f3028802d6bddfe15b61340e20def -->
## api/sections/slug
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/sections/slug',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sections/slug'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sections/slug"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/sections/slug`


<!-- END_8f0f3028802d6bddfe15b61340e20def -->

<!-- START_3815834b2e296ea0976dfdd99e5a7fa7 -->
## api/sections/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/sections/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sections/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sections/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/sections/create`


<!-- END_3815834b2e296ea0976dfdd99e5a7fa7 -->

<!-- START_ba07eea77f421628206dda05cdc73017 -->
## api/sections/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/sections/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sections/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sections/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/sections/delete`


<!-- END_ba07eea77f421628206dda05cdc73017 -->

<!-- START_c5850f7c18b5290c88b9cd7b3c76ada5 -->
## api/sections/form
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/sections/form',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sections/form'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sections/form"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/sections/form`


<!-- END_c5850f7c18b5290c88b9cd7b3c76ada5 -->

<!-- START_0fe548a4d8c8fd330fe0de16b1c3dc7b -->
## api/sections/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/sections/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sections/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sections/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/sections/update`


<!-- END_0fe548a4d8c8fd330fe0de16b1c3dc7b -->

<!-- START_201a2227f5b400f2a5b982eb45576c9b -->
## api/sections/show/{id}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/sections/show/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sections/show/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sections/show/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/sections/show/{id}`

`POST api/sections/show/{id}`

`PUT api/sections/show/{id}`

`PATCH api/sections/show/{id}`

`DELETE api/sections/show/{id}`

`OPTIONS api/sections/show/{id}`


<!-- END_201a2227f5b400f2a5b982eb45576c9b -->

<!-- START_30e9dc0e563741fb6e4df13ceee5be59 -->
## api/sections/site
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/sections/site',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sections/site'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sections/site"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/sections/site`


<!-- END_30e9dc0e563741fb6e4df13ceee5be59 -->

<!-- START_33d9202833e2f1e14ca8b0ad7af75663 -->
## api/sections/mass_delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/sections/mass_delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sections/mass_delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sections/mass_delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/sections/mass_delete`


<!-- END_33d9202833e2f1e14ca8b0ad7af75663 -->

<!-- START_330c0345292242cacb990b0d999fa238 -->
## api/sections/section
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/sections/section',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sections/section'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sections/section"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/sections/section`


<!-- END_330c0345292242cacb990b0d999fa238 -->

<!-- START_23c940fe91d00ea63aa51eb56e459436 -->
## api/sections
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/sections',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sections'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sections"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
null
```

### HTTP Request
`GET api/sections`


<!-- END_23c940fe91d00ea63aa51eb56e459436 -->

<!-- START_3e1e122e454d4a97f3a2a4d24fae6775 -->
## api/sections/sort
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/sections/sort',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sections/sort'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sections/sort"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
null
```

### HTTP Request
`GET api/sections/sort`


<!-- END_3e1e122e454d4a97f3a2a4d24fae6775 -->

<!-- START_e348a6c93efb3d326f830c71910619ed -->
## api/section/{section}-{id}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/section/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/section/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/section/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
null
```

### HTTP Request
`GET api/section/{section}-{id}`


<!-- END_e348a6c93efb3d326f830c71910619ed -->

<!-- START_bba7f0c25db62cb8b3931cbc7b6d09f3 -->
## articles
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/articles',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/articles'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/articles"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET articles`


<!-- END_bba7f0c25db62cb8b3931cbc7b6d09f3 -->

<!-- START_7c88dbe5d2d94299fabad65a9cfc47eb -->
## article/{title?}-{id}.html
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/article/-1.html',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/article/-1.html'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/article/-1.html"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
null
```

### HTTP Request
`GET article/{title?}-{id}.html`


<!-- END_7c88dbe5d2d94299fabad65a9cfc47eb -->

<!-- START_0d4cb2104f73e3ee9cf74a52a015de76 -->
## api/articles
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/articles',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/articles'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/articles"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
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
    "result": "error",
    "errors": {
        "message": "Сайт не найден..."
    },
    "code": 400,
    "data": null
}
```

### HTTP Request
`GET api/articles`


<!-- END_0d4cb2104f73e3ee9cf74a52a015de76 -->

<!-- START_fe4a4c7dee4799fb06b6a8ae91b0c3ea -->
## api/article/{title}-{id}.html
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/article/1.html',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/article/1.html'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/article/1.html"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
null
```

### HTTP Request
`GET api/article/{title}-{id}.html`


<!-- END_fe4a4c7dee4799fb06b6a8ae91b0c3ea -->

<!-- START_19ce296882c261f2f5c6d635c25d0abd -->
## api/articles/sort
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/articles/sort',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/articles/sort'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/articles/sort"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
null
```

### HTTP Request
`GET api/articles/sort`


<!-- END_19ce296882c261f2f5c6d635c25d0abd -->

<!-- START_c1552794c37ccdfcbbaa4b6180679841 -->
## api/articles/mass_delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/articles/mass_delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/articles/mass_delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/articles/mass_delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/articles/mass_delete`


<!-- END_c1552794c37ccdfcbbaa4b6180679841 -->

<!-- START_7e464687b30cb18e75c426fcda3a579b -->
## api/articles/section
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/articles/section',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/articles/section'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/articles/section"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "error": "Вы не авторизированы...",
    "success": false,
    "notice": ""
}
```

### HTTP Request
`GET api/articles/section`


<!-- END_7e464687b30cb18e75c426fcda3a579b -->

<!-- START_3cd81598b67a1afc581caa882e07b995 -->
## api/articles/form
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/articles/form',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/articles/form'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/articles/form"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "error": "Вы не авторизированы...",
    "success": false,
    "notice": ""
}
```

### HTTP Request
`GET api/articles/form`


<!-- END_3cd81598b67a1afc581caa882e07b995 -->

<!-- START_1e905a4b5d1c96671d985ec09c72d5d7 -->
## api/articles/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/articles/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/articles/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/articles/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/articles/create`


<!-- END_1e905a4b5d1c96671d985ec09c72d5d7 -->

<!-- START_3ccdb3abe928b57d13c9868d7779166b -->
## api/articles/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/articles/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/articles/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/articles/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/articles/update`


<!-- END_3ccdb3abe928b57d13c9868d7779166b -->

<!-- START_f8ddf30bc9f5503eed2352460031583d -->
## api/articles/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/articles/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/articles/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/articles/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/articles/delete`


<!-- END_f8ddf30bc9f5503eed2352460031583d -->

<!-- START_cf12ce7009c34a30cffcda26ecdd0c4f -->
## api/articles/slug
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/articles/slug',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/articles/slug'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/articles/slug"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "error": "Вы не авторизированы...",
    "success": false,
    "notice": ""
}
```

### HTTP Request
`GET api/articles/slug`


<!-- END_cf12ce7009c34a30cffcda26ecdd0c4f -->

<!-- START_ce78a3a6ff60252953dd0d68134a3775 -->
## api/articles/auto_save
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/articles/auto_save',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/articles/auto_save'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/articles/auto_save"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/articles/auto_save`


<!-- END_ce78a3a6ff60252953dd0d68134a3775 -->

<!-- START_b3a644574a780d914b846ac951f2913c -->
## api/articles/cancel
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/articles/cancel',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/articles/cancel'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/articles/cancel"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/articles/cancel`


<!-- END_b3a644574a780d914b846ac951f2913c -->

<!-- START_8260708120d10e27a066ebf8f7e3aa6a -->
## api/articles/revisions
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/articles/revisions',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/articles/revisions'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/articles/revisions"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "error": "Вы не авторизированы...",
    "success": false,
    "notice": ""
}
```

### HTTP Request
`GET api/articles/revisions`


<!-- END_8260708120d10e27a066ebf8f7e3aa6a -->

<!-- START_102fc677cb68648be10dd7382bfbc8b4 -->
## api/articles/show_revision
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/articles/show_revision',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/articles/show_revision'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/articles/show_revision"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "error": "Вы не авторизированы...",
    "success": false,
    "notice": ""
}
```

### HTTP Request
`GET api/articles/show_revision`


<!-- END_102fc677cb68648be10dd7382bfbc8b4 -->

<!-- START_a281a91104f975faf9f62a86e4381e59 -->
## api/articles/delete_language
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/articles/delete_language',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/articles/delete_language'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/articles/delete_language"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/articles/delete_language`


<!-- END_a281a91104f975faf9f62a86e4381e59 -->

<!-- START_5a98a0730323c71f3cbe58698299ff5e -->
## api/articles/delete_article_group_article
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/articles/delete_article_group_article',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/articles/delete_article_group_article'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/articles/delete_article_group_article"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/articles/delete_article_group_article`


<!-- END_5a98a0730323c71f3cbe58698299ff5e -->

<!-- START_adcbb9172b8b3f978f334683d23c9f93 -->
## page/{slug?}-{id}.html
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/page/-1.html',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/page/-1.html'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/page/-1.html"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
null
```

### HTTP Request
`GET page/{slug?}-{id}.html`


<!-- END_adcbb9172b8b3f978f334683d23c9f93 -->

<!-- START_645d6c53d0615e80fd583bfba1feb1ae -->
## api/pages/home
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/pages/home',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/pages/home'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/pages/home"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/pages/home`


<!-- END_645d6c53d0615e80fd583bfba1feb1ae -->

<!-- START_69e40530691a8c1a61cd8d9e44be1e5a -->
## api/pages/settings
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/pages/settings',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/pages/settings'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/pages/settings"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/pages/settings`


<!-- END_69e40530691a8c1a61cd8d9e44be1e5a -->

<!-- START_1b7b15fa88ce67280faaf2c43243fa58 -->
## api/pages/{slug?}-{id}.html
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/pages/-1.html',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/pages/-1.html'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/pages/-1.html"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
null
```

### HTTP Request
`GET api/pages/{slug?}-{id}.html`


<!-- END_1b7b15fa88ce67280faaf2c43243fa58 -->

<!-- START_a57725b71c86defca1a28c838f894c5f -->
## api/pages
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/pages',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/pages'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/pages"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "error": "Вы не авторизированы...",
    "success": false,
    "notice": ""
}
```

### HTTP Request
`GET api/pages`


<!-- END_a57725b71c86defca1a28c838f894c5f -->

<!-- START_caa025f427924fde9905b0558bff61b1 -->
## api/pages/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/pages/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/pages/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/pages/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/pages/create`


<!-- END_caa025f427924fde9905b0558bff61b1 -->

<!-- START_d9f2554fb896914c38c5685d5edbac88 -->
## api/pages/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/pages/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/pages/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/pages/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/pages/update`


<!-- END_d9f2554fb896914c38c5685d5edbac88 -->

<!-- START_610e983ec9dc6b2de6d0d6e62731ffbb -->
## api/pages/active
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/pages/active',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/pages/active'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/pages/active"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/pages/active`


<!-- END_610e983ec9dc6b2de6d0d6e62731ffbb -->

<!-- START_59919dedcbb27b976faef2128a641d0e -->
## api/pages/edit_mode
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/pages/edit_mode',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/pages/edit_mode'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/pages/edit_mode"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/pages/edit_mode`


<!-- END_59919dedcbb27b976faef2128a641d0e -->

<!-- START_1ced996075ede9e31f27c6217f8627ef -->
## api/pages/form
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/pages/form',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/pages/form'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/pages/form"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "error": "Вы не авторизированы...",
    "success": false,
    "notice": ""
}
```

### HTTP Request
`GET api/pages/form`


<!-- END_1ced996075ede9e31f27c6217f8627ef -->

<!-- START_50f82cbfd14b8c5aeeb952ffed579746 -->
## api/pages/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/pages/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/pages/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/pages/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/pages/delete`


<!-- END_50f82cbfd14b8c5aeeb952ffed579746 -->

<!-- START_e2d7d4b1c10287735ce21b7e7fbf37c5 -->
## api/pages/undo
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/pages/undo',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/pages/undo'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/pages/undo"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/pages/undo`


<!-- END_e2d7d4b1c10287735ce21b7e7fbf37c5 -->

<!-- START_82e09df014abdc42a383d7e2147a8392 -->
## api/pages/stroke/sort
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/pages/stroke/sort',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/pages/stroke/sort'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/pages/stroke/sort"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/pages/stroke/sort`


<!-- END_82e09df014abdc42a383d7e2147a8392 -->

<!-- START_4414026b4d692de5dd38c8dbf32b2b9e -->
## api/pages/stroke/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/pages/stroke/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/pages/stroke/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/pages/stroke/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/pages/stroke/create`


<!-- END_4414026b4d692de5dd38c8dbf32b2b9e -->

<!-- START_59087796d86cbac6ec9edcfe39bde120 -->
## api/pages/stroke/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/pages/stroke/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/pages/stroke/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/pages/stroke/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/pages/stroke/update`


<!-- END_59087796d86cbac6ec9edcfe39bde120 -->

<!-- START_60ef2d10f388f43a7c1894e794aa6109 -->
## api/pages/stroke/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/pages/stroke/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/pages/stroke/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/pages/stroke/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/pages/stroke/delete`


<!-- END_60ef2d10f388f43a7c1894e794aa6109 -->

<!-- START_fddf7536e16e27ad9159a67db50ae905 -->
## api/pages/stroke/active
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/pages/stroke/active',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/pages/stroke/active'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/pages/stroke/active"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/pages/stroke/active`


<!-- END_fddf7536e16e27ad9159a67db50ae905 -->

<!-- START_38e7564785344f76b99373f2b2c12ebe -->
## api/pages/stroke/modules/sort
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/pages/stroke/modules/sort',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/pages/stroke/modules/sort'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/pages/stroke/modules/sort"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/pages/stroke/modules/sort`


<!-- END_38e7564785344f76b99373f2b2c12ebe -->

<!-- START_7bcb807802a5799e0e6a6ba10d20609f -->
## api/pages/stroke/modules/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/pages/stroke/modules/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/pages/stroke/modules/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/pages/stroke/modules/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/pages/stroke/modules/create`


<!-- END_7bcb807802a5799e0e6a6ba10d20609f -->

<!-- START_bc2dcbb1aa42e17c3ff0b0849d27b6c2 -->
## api/pages/stroke/modules/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/pages/stroke/modules/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/pages/stroke/modules/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/pages/stroke/modules/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/pages/stroke/modules/update`


<!-- END_bc2dcbb1aa42e17c3ff0b0849d27b6c2 -->

<!-- START_c94727b29adfe36e9c742fb998334386 -->
## api/pages/stroke/modules/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/pages/stroke/modules/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/pages/stroke/modules/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/pages/stroke/modules/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/pages/stroke/modules/delete`


<!-- END_c94727b29adfe36e9c742fb998334386 -->

<!-- START_a128e8cde31590a96ae6331257bd16d9 -->
## api/pages/stroke/modules/form
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/pages/stroke/modules/form',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/pages/stroke/modules/form'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/pages/stroke/modules/form"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "error": "Вы не авторизированы...",
    "success": false,
    "notice": ""
}
```

### HTTP Request
`GET api/pages/stroke/modules/form`


<!-- END_a128e8cde31590a96ae6331257bd16d9 -->

<!-- START_b674bd9bf15ba91de7237acfbf6dce4a -->
## api/pages/stroke/modules/update_content_options
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/pages/stroke/modules/update_content_options',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/pages/stroke/modules/update_content_options'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/pages/stroke/modules/update_content_options"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/pages/stroke/modules/update_content_options`


<!-- END_b674bd9bf15ba91de7237acfbf6dce4a -->

<!-- START_07bf7c8c0b7f6921f0820aaab52e1466 -->
## api/pages/stroke/blocks/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/pages/stroke/blocks/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/pages/stroke/blocks/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/pages/stroke/blocks/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/pages/stroke/blocks/create`


<!-- END_07bf7c8c0b7f6921f0820aaab52e1466 -->

<!-- START_324f9c9788a38658cd944afd0a8d08f4 -->
## api/pages/stroke/blocks/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/pages/stroke/blocks/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/pages/stroke/blocks/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/pages/stroke/blocks/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/pages/stroke/blocks/update`


<!-- END_324f9c9788a38658cd944afd0a8d08f4 -->

<!-- START_251b2cc99b08a4defa9d27800b118244 -->
## api/pages/stroke/blocks/sort
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/pages/stroke/blocks/sort',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/pages/stroke/blocks/sort'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/pages/stroke/blocks/sort"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/pages/stroke/blocks/sort`


<!-- END_251b2cc99b08a4defa9d27800b118244 -->

<!-- START_6bdd062ad18c788a84eb8fb18d07b371 -->
## api/credentials/user/{id}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/credentials/user/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/credentials/user/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/credentials/user/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/credentials/user/{id}`


<!-- END_6bdd062ad18c788a84eb8fb18d07b371 -->

<!-- START_6640a155142c965806443cb392740450 -->
## api/credentials/user
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/credentials/user',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/credentials/user'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/credentials/user"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/credentials/user`


<!-- END_6640a155142c965806443cb392740450 -->

<!-- START_5caaf1a3eabe7ecc4bd7b7ae2f402764 -->
## credentials/token/{token}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/credentials/token/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/credentials/token/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/credentials/token/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET credentials/token/{token}`


<!-- END_5caaf1a3eabe7ecc4bd7b7ae2f402764 -->

<!-- START_445e4e3f910d7d7ae408d9d44378565d -->
## credentials/login/{token}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/credentials/login/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/credentials/login/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/credentials/login/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET credentials/login/{token}`


<!-- END_445e4e3f910d7d7ae408d9d44378565d -->

<!-- START_4f86f634ba949c9075a3ec3067427918 -->
## credentials/logout
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/credentials/logout',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/credentials/logout'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/credentials/logout"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET credentials/logout`


<!-- END_4f86f634ba949c9075a3ec3067427918 -->

<!-- START_ba53c93f9b90059981e56af993fee224 -->
## credentials/guest
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/credentials/guest',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/credentials/guest'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/credentials/guest"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET credentials/guest`


<!-- END_ba53c93f9b90059981e56af993fee224 -->

<!-- START_185fd3c43a559deae3dd2d8787d99905 -->
## credentials/check
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/credentials/check',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/credentials/check'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/credentials/check"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET credentials/check`


<!-- END_185fd3c43a559deae3dd2d8787d99905 -->

<!-- START_263be5cbd2fca8a70b70d010372bff0e -->
## credentials/erase_guest_cookie
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/credentials/erase_guest_cookie',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/credentials/erase_guest_cookie'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/credentials/erase_guest_cookie"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET credentials/erase_guest_cookie`


<!-- END_263be5cbd2fca8a70b70d010372bff0e -->

<!-- START_3e2ed1b4df0ee0ad98a3ad235ce32b97 -->
## credentials/native_logout
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/credentials/native_logout',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/credentials/native_logout'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/credentials/native_logout"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET credentials/native_logout`


<!-- END_3e2ed1b4df0ee0ad98a3ad235ce32b97 -->

<!-- START_5b278b1a06d9b8a8ac4ce1ed2b221a97 -->
## api/domains/personal
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/domains/personal',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/domains/personal'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/domains/personal"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/domains/personal`

`POST api/domains/personal`

`PUT api/domains/personal`

`PATCH api/domains/personal`

`DELETE api/domains/personal`

`OPTIONS api/domains/personal`


<!-- END_5b278b1a06d9b8a8ac4ce1ed2b221a97 -->

<!-- START_3127f5f7fae2e143a83fe31eaec7b494 -->
## api/domains/thematic
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/domains/thematic',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/domains/thematic'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/domains/thematic"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/domains/thematic`


<!-- END_3127f5f7fae2e143a83fe31eaec7b494 -->

<!-- START_20bb6c0ce5e2d5e6329ffebe35854f55 -->
## api/domains/check_subdomain
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/domains/check_subdomain',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/domains/check_subdomain'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/domains/check_subdomain"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/domains/check_subdomain`


<!-- END_20bb6c0ce5e2d5e6329ffebe35854f55 -->

<!-- START_d9cee42c5266f248bdf9da705c766100 -->
## api/domains/check
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/domains/check',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/domains/check'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/domains/check"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/domains/check`


<!-- END_d9cee42c5266f248bdf9da705c766100 -->

<!-- START_01d6d6c829bedc728141ac677ce6801a -->
## api/pool/index
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/pool/index',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/pool/index'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/pool/index"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/pool/index`


<!-- END_01d6d6c829bedc728141ac677ce6801a -->

<!-- START_c368827eedb8f902da27ede70ccc8285 -->
## api/pool/answer
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/pool/answer',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/pool/answer'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/pool/answer"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/pool/answer`


<!-- END_c368827eedb8f902da27ede70ccc8285 -->

<!-- START_8594a00691cf8d7c40a5a34be354ad5d -->
## api/storage/delete_object
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/storage/delete_object',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/delete_object'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/delete_object"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/storage/delete_object`


<!-- END_8594a00691cf8d7c40a5a34be354ad5d -->

<!-- START_acdafd289a63d3173f3f01872d453c2f -->
## api/storage/force_delete_object
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/storage/force_delete_object',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/force_delete_object'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/force_delete_object"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/storage/force_delete_object`


<!-- END_acdafd289a63d3173f3f01872d453c2f -->

<!-- START_f118f7ec7b7eb2b7b6433cf13def9d77 -->
## api/storage/delete_bin_file
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/storage/delete_bin_file',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/delete_bin_file'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/delete_bin_file"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/storage/delete_bin_file`


<!-- END_f118f7ec7b7eb2b7b6433cf13def9d77 -->

<!-- START_470f6002731ce5e5fac649774590c8f8 -->
## api/storage/undelete_object
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/storage/undelete_object',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/undelete_object'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/undelete_object"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/storage/undelete_object`


<!-- END_470f6002731ce5e5fac649774590c8f8 -->

<!-- START_97cbbfe5d4244c681d510da1dd254cf5 -->
## api/storage/recycle
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/storage/recycle',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/recycle'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/recycle"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/storage/recycle`


<!-- END_97cbbfe5d4244c681d510da1dd254cf5 -->

<!-- START_e4e9991cfcda64fa612d56e1e75e03bd -->
## api/storage/favorite
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/storage/favorite',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/favorite'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/favorite"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/storage/favorite`


<!-- END_e4e9991cfcda64fa612d56e1e75e03bd -->

<!-- START_2a46ce1ce29cb5927bb2765c1b399c9a -->
## api/storage/favorite_file
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/storage/favorite_file',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/favorite_file'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/favorite_file"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/storage/favorite_file`


<!-- END_2a46ce1ce29cb5927bb2765c1b399c9a -->

<!-- START_8c45d4b2b0ce61c9edfd37da757c9afe -->
## api/storage/unfavorite_file
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/storage/unfavorite_file',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/unfavorite_file'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/unfavorite_file"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/storage/unfavorite_file`


<!-- END_8c45d4b2b0ce61c9edfd37da757c9afe -->

<!-- START_cb621997b566a1679cbe0c12cf09ac53 -->
## api/storage/images
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/storage/images',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/images'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/images"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/storage/images`


<!-- END_cb621997b566a1679cbe0c12cf09ac53 -->

<!-- START_7308be7579a537a30d968fa9fe1e1b18 -->
## api/storage/images/sort
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/storage/images/sort',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/images/sort'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/images/sort"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/storage/images/sort`


<!-- END_7308be7579a537a30d968fa9fe1e1b18 -->

<!-- START_9b26bf69121efff5a562eee2fd2fde08 -->
## api/storage/files
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/storage/files',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/files'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/files"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/storage/files`


<!-- END_9b26bf69121efff5a562eee2fd2fde08 -->

<!-- START_516e89eb28ee6a62cfbb2d34f7c415a4 -->
## api/storage/objects
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/storage/objects',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/objects'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/objects"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/storage/objects`


<!-- END_516e89eb28ee6a62cfbb2d34f7c415a4 -->

<!-- START_8bd906c5c670100ba74f69803c9fca99 -->
## api/storage/tag/{name}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/storage/tag/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/tag/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/tag/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/storage/tag/{name}`


<!-- END_8bd906c5c670100ba74f69803c9fca99 -->

<!-- START_af7e3398277c896e4805de396d284980 -->
## api/storage/remove_tag
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/storage/remove_tag',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/remove_tag'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/remove_tag"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/storage/remove_tag`


<!-- END_af7e3398277c896e4805de396d284980 -->

<!-- START_dcd739929bf730098dcc0f2dc3203865 -->
## api/storage/remove_user_tag
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/storage/remove_user_tag',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/remove_user_tag'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/remove_user_tag"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/storage/remove_user_tag`


<!-- END_dcd739929bf730098dcc0f2dc3203865 -->

<!-- START_26d7d1a2903ef926facbd3edb21ab197 -->
## api/storage/edit_user_tag
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/storage/edit_user_tag',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/edit_user_tag'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/edit_user_tag"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/storage/edit_user_tag`


<!-- END_26d7d1a2903ef926facbd3edb21ab197 -->

<!-- START_12069b69e106e22de6fb30e78e753fa7 -->
## api/storage/update_user_tag
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/storage/update_user_tag',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/update_user_tag'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/update_user_tag"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/storage/update_user_tag`


<!-- END_12069b69e106e22de6fb30e78e753fa7 -->

<!-- START_b1e0a73573bafd76e0b286515bb58961 -->
## api/storage/add_tag_to_object
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/storage/add_tag_to_object',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/add_tag_to_object'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/add_tag_to_object"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/storage/add_tag_to_object`


<!-- END_b1e0a73573bafd76e0b286515bb58961 -->

<!-- START_9ecf3bf1c65c15627e4bd207da657969 -->
## api/storage/add_tag
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/storage/add_tag',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/add_tag'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/add_tag"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/storage/add_tag`


<!-- END_9ecf3bf1c65c15627e4bd207da657969 -->

<!-- START_0314e6ec67b0e6725af415655c8f3d38 -->
## api/storage/filter_tag
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/storage/filter_tag',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/filter_tag'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/filter_tag"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/storage/filter_tag`


<!-- END_0314e6ec67b0e6725af415655c8f3d38 -->

<!-- START_7c66e79840f3cf8bafbc7cf78928ee0f -->
## api/storage/add_files
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/storage/add_files',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/add_files'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/add_files"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/storage/add_files`


<!-- END_7c66e79840f3cf8bafbc7cf78928ee0f -->

<!-- START_c300310aeef849a9b76ec3aa6297968c -->
## api/storage/add_base64_files
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/storage/add_base64_files',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/add_base64_files'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/add_base64_files"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/storage/add_base64_files`


<!-- END_c300310aeef849a9b76ec3aa6297968c -->

<!-- START_c43ba98583272f8ce678cf60c1807aba -->
## api/storage/add_url
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/storage/add_url',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/add_url'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/add_url"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/storage/add_url`


<!-- END_c43ba98583272f8ce678cf60c1807aba -->

<!-- START_163e6cd9db2fe254f0fe1104542ea7c4 -->
## api/storage/tags
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/storage/tags',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/tags'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/tags"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/storage/tags`


<!-- END_163e6cd9db2fe254f0fe1104542ea7c4 -->

<!-- START_621345921bb3104b5c4cf052415ce1a3 -->
## api/storage/search_tag
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/storage/search_tag',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/search_tag'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/search_tag"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/storage/search_tag`


<!-- END_621345921bb3104b5c4cf052415ce1a3 -->

<!-- START_7b554079bdecdaa114c553dd4a5e71a5 -->
## api/storage/search
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/storage/search',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/search'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/search"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/storage/search`


<!-- END_7b554079bdecdaa114c553dd4a5e71a5 -->

<!-- START_eedd6ba65a60bf706b8275d91651e7c0 -->
## api/storage/no_file_tags
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/storage/no_file_tags',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/no_file_tags'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/no_file_tags"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/storage/no_file_tags`


<!-- END_eedd6ba65a60bf706b8275d91651e7c0 -->

<!-- START_200c93246092ea53f81cbe6b1eb6f7da -->
## api/storage/add_multi_tag
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/storage/add_multi_tag',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/add_multi_tag'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/add_multi_tag"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/storage/add_multi_tag`


<!-- END_200c93246092ea53f81cbe6b1eb6f7da -->

<!-- START_32a330b7722c29a0695a7d1669dc4e09 -->
## api/storage/multi_recycle
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/storage/multi_recycle',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/multi_recycle'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/multi_recycle"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/storage/multi_recycle`


<!-- END_32a330b7722c29a0695a7d1669dc4e09 -->

<!-- START_e712ecf35abc175adf272c639d4ca69e -->
## api/storage/multi_recycle_tags
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/storage/multi_recycle_tags',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/multi_recycle_tags'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/multi_recycle_tags"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/storage/multi_recycle_tags`


<!-- END_e712ecf35abc175adf272c639d4ca69e -->

<!-- START_9312783ba049877a736229f32057b65c -->
## api/storage/multi_download
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/storage/multi_download',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/multi_download'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/multi_download"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/storage/multi_download`


<!-- END_9312783ba049877a736229f32057b65c -->

<!-- START_9cb0a0ea98eee4686cdb08bdc4745966 -->
## api/storage/combine_tags
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/storage/combine_tags',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/combine_tags'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/combine_tags"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/storage/combine_tags`


<!-- END_9cb0a0ea98eee4686cdb08bdc4745966 -->

<!-- START_a3f37e8b15c789cb019acba10aa41171 -->
## api/storage/add_image
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/storage/add_image',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/add_image'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/add_image"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/storage/add_image`


<!-- END_a3f37e8b15c789cb019acba10aa41171 -->

<!-- START_25125b3103338025b07d79e8492f132b -->
## api/storage/validate_url_image
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/storage/validate_url_image',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/validate_url_image'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/validate_url_image"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/storage/validate_url_image`


<!-- END_25125b3103338025b07d79e8492f132b -->

<!-- START_c714c8325a5b29b39248f662865e1a85 -->
## api/storage/add_images
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/storage/add_images',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/add_images'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/add_images"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/storage/add_images`


<!-- END_c714c8325a5b29b39248f662865e1a85 -->

<!-- START_94fb89ff63b4dc56aa6827e72f03f6e7 -->
## api/storage/download_zip/{zipname}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/storage/download_zip/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/download_zip/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/download_zip/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/storage/download_zip/{zipname}`


<!-- END_94fb89ff63b4dc56aa6827e72f03f6e7 -->

<!-- START_67135a23c379a91e85e2c113e8d3de93 -->
## api/storage/get_image_from_url
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/storage/get_image_from_url',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/get_image_from_url'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/get_image_from_url"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/storage/get_image_from_url`


<!-- END_67135a23c379a91e85e2c113e8d3de93 -->

<!-- START_dd1be769f50afce759cbc0ba77083a08 -->
## api/storage/add_chunked_files
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/storage/add_chunked_files',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/add_chunked_files'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/add_chunked_files"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/storage/add_chunked_files`


<!-- END_dd1be769f50afce759cbc0ba77083a08 -->

<!-- START_65ffb040a311ee2b5db4f5f9a5a3bee7 -->
## api/storage/download/{id}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/storage/download/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/storage/download/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/storage/download/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/storage/download/{id}`


<!-- END_65ffb040a311ee2b5db4f5f9a5a3bee7 -->

<!-- START_fe714b67ab031b9b0bd0b1577af9daa2 -->
## api/menu
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/menu',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/menu'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/menu"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/menu`

`POST api/menu`

`PUT api/menu`

`PATCH api/menu`

`DELETE api/menu`

`OPTIONS api/menu`


<!-- END_fe714b67ab031b9b0bd0b1577af9daa2 -->

<!-- START_215b4a3214a88e17c6d57864eb8b31d3 -->
## api/menu/item/{id}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/menu/item/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/menu/item/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/menu/item/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/menu/item/{id}`

`POST api/menu/item/{id}`

`PUT api/menu/item/{id}`

`PATCH api/menu/item/{id}`

`DELETE api/menu/item/{id}`

`OPTIONS api/menu/item/{id}`


<!-- END_215b4a3214a88e17c6d57864eb8b31d3 -->

<!-- START_f49d83a1636a4521356d8ee12ebaa499 -->
## api/comments/add
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/comments/add',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/comments/add'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/comments/add"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/comments/add`


<!-- END_f49d83a1636a4521356d8ee12ebaa499 -->

<!-- START_f15a40b1229a571aaea3dd9e84687bc4 -->
## api/comments/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/comments/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/comments/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/comments/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/comments/delete`


<!-- END_f15a40b1229a571aaea3dd9e84687bc4 -->

<!-- START_ca994afb16be1960a023584cbcd424da -->
## api/comments/moderate
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/comments/moderate',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/comments/moderate'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/comments/moderate"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/comments/moderate`


<!-- END_ca994afb16be1960a023584cbcd424da -->

<!-- START_c98636a73d829779c8d15edfdeba8687 -->
## api/comments/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/comments/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/comments/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/comments/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/comments/update`


<!-- END_c98636a73d829779c8d15edfdeba8687 -->

<!-- START_bdbcd37206d6fbac3cdf416c652148dc -->
## api/comments/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/comments/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/comments/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/comments/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/comments/edit`


<!-- END_bdbcd37206d6fbac3cdf416c652148dc -->

<!-- START_bb9a26471779eee17766a38aed4f9d69 -->
## api/comments/batch_delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/comments/batch_delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/comments/batch_delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/comments/batch_delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/comments/batch_delete`


<!-- END_bb9a26471779eee17766a38aed4f9d69 -->

<!-- START_2db594376cb358e896fa7d762865d3e8 -->
## api/comments/batch_change_status
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/comments/batch_change_status',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/comments/batch_change_status'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/comments/batch_change_status"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/comments/batch_change_status`


<!-- END_2db594376cb358e896fa7d762865d3e8 -->

<!-- START_7e46e641041815fc36186469376a3926 -->
## api/comments/batch_move
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/comments/batch_move',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/comments/batch_move'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/comments/batch_move"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/comments/batch_move`


<!-- END_7e46e641041815fc36186469376a3926 -->

<!-- START_7b5ba08fa1c0b1d6076f4c4568949055 -->
## api/comments/pin
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/comments/pin',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/comments/pin'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/comments/pin"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/comments/pin`


<!-- END_7b5ba08fa1c0b1d6076f4c4568949055 -->

<!-- START_a13cbef5f6533b8fea1b5505d67298c3 -->
## api/comments/unpin
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/comments/unpin',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/comments/unpin'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/comments/unpin"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/comments/unpin`


<!-- END_a13cbef5f6533b8fea1b5505d67298c3 -->

<!-- START_54d91904f2389a35a438959ebdeb6335 -->
## api/comments/archive
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/comments/archive',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/comments/archive'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/comments/archive"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/comments/archive`


<!-- END_54d91904f2389a35a438959ebdeb6335 -->

<!-- START_38702aa9c6f225b36ff53e89358992ea -->
## api/comments
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/comments',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/comments'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/comments"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/comments`


<!-- END_38702aa9c6f225b36ff53e89358992ea -->

<!-- START_6aa89f88b8f871d4849dae921975d27c -->
## api/profile/search/article
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/profile/search/article',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/profile/search/article'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/profile/search/article"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/profile/search/article`


<!-- END_6aa89f88b8f871d4849dae921975d27c -->

<!-- START_e87a8ba1fb8b28951a64ae306509e191 -->
## api/profile/save_status
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/profile/save_status',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/profile/save_status'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/profile/save_status"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/profile/save_status`


<!-- END_e87a8ba1fb8b28951a64ae306509e191 -->

<!-- START_a9eb66bb0e90155c598ad945683868a5 -->
## api/profile/save_images
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/profile/save_images',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/profile/save_images'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/profile/save_images"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/profile/save_images`


<!-- END_a9eb66bb0e90155c598ad945683868a5 -->

<!-- START_56fa65864f9042455fb1d9c2254bb62c -->
## api/profile/delete_images
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/profile/delete_images',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/profile/delete_images'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/profile/delete_images"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/profile/delete_images`


<!-- END_56fa65864f9042455fb1d9c2254bb62c -->

<!-- START_82efce413877497111fc539d6bb9bc25 -->
## api/profile/change_domain_nick
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/profile/change_domain_nick',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/profile/change_domain_nick'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/profile/change_domain_nick"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/profile/change_domain_nick`


<!-- END_82efce413877497111fc539d6bb9bc25 -->

<!-- START_5d9246c84296cdcb4369111707f1ae19 -->
## api/profile/statuses
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/profile/statuses',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/profile/statuses'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/profile/statuses"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/profile/statuses`


<!-- END_5d9246c84296cdcb4369111707f1ae19 -->

<!-- START_1c7bb491ca90f3730229afb7a6a0013d -->
## api/profile/info
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/profile/info',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/profile/info'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/profile/info"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/profile/info`


<!-- END_1c7bb491ca90f3730229afb7a6a0013d -->

<!-- START_0d4b0b259c34ca866b298eb9bb069b7c -->
## api/profile/fields
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/profile/fields',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/profile/fields'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/profile/fields"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/profile/fields`


<!-- END_0d4b0b259c34ca866b298eb9bb069b7c -->

<!-- START_f745ae26a3c4dce733b690e328874c1d -->
## api/profile/images
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/profile/images',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/profile/images'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/profile/images"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/profile/images`


<!-- END_f745ae26a3c4dce733b690e328874c1d -->

<!-- START_6ad2f20dc78b1371805e9bbc2b547558 -->
## article/show/{title}-{id}.html
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/article/show/1.html',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/article/show/1.html'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/article/show/1.html"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
null
```

### HTTP Request
`GET article/show/{title}-{id}.html`


<!-- END_6ad2f20dc78b1371805e9bbc2b547558 -->

<!-- START_20c8e210f37092931d2d94a44f9189ae -->
## api/blog/article/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/blog/article/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/blog/article/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/blog/article/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/blog/article/create`


<!-- END_20c8e210f37092931d2d94a44f9189ae -->

<!-- START_fe022b5b01da8c9e7d644ee012cd49e3 -->
## api/blog/article/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/blog/article/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/blog/article/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/blog/article/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/blog/article/update`


<!-- END_fe022b5b01da8c9e7d644ee012cd49e3 -->

<!-- START_36132c2b7c9117e4e0f94aa632fb3bc2 -->
## api/blog/article/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/blog/article/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/blog/article/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/blog/article/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/blog/article/delete`


<!-- END_36132c2b7c9117e4e0f94aa632fb3bc2 -->

<!-- START_f696542ade8d18cb21b5d37f1a32939d -->
## api/blog/article/revisions
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/blog/article/revisions',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/blog/article/revisions'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/blog/article/revisions"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/blog/article/revisions`


<!-- END_f696542ade8d18cb21b5d37f1a32939d -->

<!-- START_0c9cde88505c9b2341f950865d943545 -->
## api/blog/article/form
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/blog/article/form',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/blog/article/form'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/blog/article/form"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/blog/article/form`


<!-- END_0c9cde88505c9b2341f950865d943545 -->

<!-- START_9a63a15f7ad8db1e703c18fe1d9abeb3 -->
## api/blog/article/slug
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/blog/article/slug',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/blog/article/slug'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/blog/article/slug"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/blog/article/slug`


<!-- END_9a63a15f7ad8db1e703c18fe1d9abeb3 -->

<!-- START_4451931af8d12b4ba98d68c679363db4 -->
## api/blog/article/mass_delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/blog/article/mass_delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/blog/article/mass_delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/blog/article/mass_delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/blog/article/mass_delete`


<!-- END_4451931af8d12b4ba98d68c679363db4 -->

<!-- START_f73035a5094849e988177ce1e03c2a87 -->
## api/blog/article/auto_save
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/blog/article/auto_save',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/blog/article/auto_save'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/blog/article/auto_save"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/blog/article/auto_save`


<!-- END_f73035a5094849e988177ce1e03c2a87 -->

<!-- START_530e1f3be3dcfbbf51b6132431b632ab -->
## api/blog/article/show_revision
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/blog/article/show_revision',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/blog/article/show_revision'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/blog/article/show_revision"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/blog/article/show_revision`


<!-- END_530e1f3be3dcfbbf51b6132431b632ab -->

<!-- START_b6f551a6fc9e01031afa74782cfc1bbc -->
## api/blog/section/slug
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/blog/section/slug',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/blog/section/slug'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/blog/section/slug"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/blog/section/slug`


<!-- END_b6f551a6fc9e01031afa74782cfc1bbc -->

<!-- START_518a2cd3731cc67370c7943b1362d075 -->
## api/blog/section/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/blog/section/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/blog/section/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/blog/section/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/blog/section/create`


<!-- END_518a2cd3731cc67370c7943b1362d075 -->

<!-- START_e99671e2d632e166ea0a8fa544415079 -->
## api/blog/section/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/blog/section/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/blog/section/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/blog/section/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/blog/section/delete`


<!-- END_e99671e2d632e166ea0a8fa544415079 -->

<!-- START_47bd15e9949f887d2d6e4a1ccbe0f2b0 -->
## api/blog/section/form
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/blog/section/form',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/blog/section/form'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/blog/section/form"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/blog/section/form`


<!-- END_47bd15e9949f887d2d6e4a1ccbe0f2b0 -->

<!-- START_e509a34ac558ae331e3967a4bd7fc932 -->
## api/blog/section/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/blog/section/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/blog/section/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/blog/section/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/blog/section/update`


<!-- END_e509a34ac558ae331e3967a4bd7fc932 -->

<!-- START_384cf0ab34f62889f546f339b16fddc9 -->
## api/blog/comments/add
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/blog/comments/add',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/blog/comments/add'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/blog/comments/add"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/blog/comments/add`


<!-- END_384cf0ab34f62889f546f339b16fddc9 -->

<!-- START_91b33d828288c8467f08cea11407d437 -->
## api/blog/comments/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/blog/comments/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/blog/comments/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/blog/comments/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/blog/comments/delete`


<!-- END_91b33d828288c8467f08cea11407d437 -->

<!-- START_a657141c55ecb7c96d3a5c64cba8c601 -->
## api/blog/comments/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/blog/comments/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/blog/comments/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/blog/comments/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/blog/comments/update`


<!-- END_a657141c55ecb7c96d3a5c64cba8c601 -->

<!-- START_2736790fef41bc445067fa2c5f76064c -->
## api/blog/comments/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/blog/comments/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/blog/comments/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/blog/comments/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/blog/comments/edit`


<!-- END_2736790fef41bc445067fa2c5f76064c -->

<!-- START_a6955e5cd297fd88d3b805ae415b8857 -->
## api/blog/comments/pin
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/blog/comments/pin',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/blog/comments/pin'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/blog/comments/pin"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/blog/comments/pin`


<!-- END_a6955e5cd297fd88d3b805ae415b8857 -->

<!-- START_acf5478263793b66dcac624d78f9ada1 -->
## api/blog/comments/unpin
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/blog/comments/unpin',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/blog/comments/unpin'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/blog/comments/unpin"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/blog/comments/unpin`


<!-- END_acf5478263793b66dcac624d78f9ada1 -->

<!-- START_0717b92839f7f5624c4a7f0297002142 -->
## api/blog/comments/archive
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/blog/comments/archive',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/blog/comments/archive'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/blog/comments/archive"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/blog/comments/archive`


<!-- END_0717b92839f7f5624c4a7f0297002142 -->

<!-- START_dbdb5d13dc07152b8b17cb313d7faf69 -->
## api/blog/comments/batch_delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/blog/comments/batch_delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/blog/comments/batch_delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/blog/comments/batch_delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/blog/comments/batch_delete`


<!-- END_dbdb5d13dc07152b8b17cb313d7faf69 -->

<!-- START_594321e8bcaa16edec8fca93e0d77ca2 -->
## api/blog/comments/batch_change_status
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/blog/comments/batch_change_status',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/blog/comments/batch_change_status'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/blog/comments/batch_change_status"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/blog/comments/batch_change_status`


<!-- END_594321e8bcaa16edec8fca93e0d77ca2 -->

<!-- START_aa451e14fd12aa79652cc5b4885f49e3 -->
## api/blog/comments/batch_move
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/blog/comments/batch_move',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/blog/comments/batch_move'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/blog/comments/batch_move"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/blog/comments/batch_move`


<!-- END_aa451e14fd12aa79652cc5b4885f49e3 -->

<!-- START_56cf4143566c355ae00cd8b58b32d9ca -->
## api/blog/comments/moderate
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/blog/comments/moderate',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/blog/comments/moderate'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/blog/comments/moderate"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/blog/comments/moderate`


<!-- END_56cf4143566c355ae00cd8b58b32d9ca -->

<!-- START_cdd78126a8358cc1b4038305fb09b674 -->
## api/profile/modules/home
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/profile/modules/home',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/profile/modules/home'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/profile/modules/home"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/profile/modules/home`


<!-- END_cdd78126a8358cc1b4038305fb09b674 -->

<!-- START_34719407007f08c7c18ae8c1d2978df2 -->
## api/profile/modules/stroke/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/profile/modules/stroke/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/profile/modules/stroke/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/profile/modules/stroke/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/profile/modules/stroke/edit`


<!-- END_34719407007f08c7c18ae8c1d2978df2 -->

<!-- START_ae585cdd4b44b26e948d2fe512837a5b -->
## api/profile/modules/stroke/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/profile/modules/stroke/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/profile/modules/stroke/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/profile/modules/stroke/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/profile/modules/stroke/create`


<!-- END_ae585cdd4b44b26e948d2fe512837a5b -->

<!-- START_7e5e5e238011b5b1cab7654fc033b5d0 -->
## api/profile/modules/stroke/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/profile/modules/stroke/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/profile/modules/stroke/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/profile/modules/stroke/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/profile/modules/stroke/update`


<!-- END_7e5e5e238011b5b1cab7654fc033b5d0 -->

<!-- START_090adcf2276b9bf6bae03e61c6e0ffee -->
## api/profile/modules/stroke/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/profile/modules/stroke/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/profile/modules/stroke/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/profile/modules/stroke/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/profile/modules/stroke/delete`


<!-- END_090adcf2276b9bf6bae03e61c6e0ffee -->

<!-- START_7215921d8a9e7e6d4170dbc69a57f8e1 -->
## api/profile/modules/stroke/sort
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/profile/modules/stroke/sort',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/profile/modules/stroke/sort'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/profile/modules/stroke/sort"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/profile/modules/stroke/sort`


<!-- END_7215921d8a9e7e6d4170dbc69a57f8e1 -->

<!-- START_caa807ac5f9dcf976b2d8e77c71deb44 -->
## api/profile/modules/information/save
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/profile/modules/information/save',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/profile/modules/information/save'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/profile/modules/information/save"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/profile/modules/information/save`


<!-- END_caa807ac5f9dcf976b2d8e77c71deb44 -->

<!-- START_e0119969fa790a191f4ece77319b0238 -->
## api/profile/modules/status/like
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/profile/modules/status/like',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/profile/modules/status/like'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/profile/modules/status/like"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/profile/modules/status/like`


<!-- END_e0119969fa790a191f4ece77319b0238 -->

<!-- START_3da3a4bd1d7f1546a7450a41f4b949e9 -->
## api/blog/sections
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/blog/sections',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/blog/sections'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/blog/sections"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/blog/sections`


<!-- END_3da3a4bd1d7f1546a7450a41f4b949e9 -->

<!-- START_0f3263245d0e96c07c69607ccf4415ae -->
## api/blog/articles
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/blog/articles',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/blog/articles'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/blog/articles"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/blog/articles`


<!-- END_0f3263245d0e96c07c69607ccf4415ae -->

<!-- START_d7ea6c8b7ac84b760b76800a29b5d0f0 -->
## api/blog/section/sort
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/blog/section/sort',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/blog/section/sort'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/blog/section/sort"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/blog/section/sort`


<!-- END_d7ea6c8b7ac84b760b76800a29b5d0f0 -->

<!-- START_322488f5360e6a63cfdba4cae46ecf55 -->
## api/blog/section/{section}-{id}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/blog/section/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/blog/section/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/blog/section/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
null
```

### HTTP Request
`GET api/blog/section/{section}-{id}`


<!-- END_322488f5360e6a63cfdba4cae46ecf55 -->

<!-- START_5af2e79efb834807296a96a7ed4f339a -->
## api/blog/article/sort
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/blog/article/sort',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/blog/article/sort'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/blog/article/sort"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/blog/article/sort`


<!-- END_5af2e79efb834807296a96a7ed4f339a -->

<!-- START_9c1ad5c141fa5e1167b41ac93f8f07ad -->
## api/blog/article/{title}-{id}.html
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/blog/article/1.html',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/blog/article/1.html'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/blog/article/1.html"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
null
```

### HTTP Request
`GET api/blog/article/{title}-{id}.html`


<!-- END_9c1ad5c141fa5e1167b41ac93f8f07ad -->

<!-- START_71c723fff2ae8b3c0253e5385ce64af1 -->
## api/blog/comments
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/blog/comments',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/blog/comments'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/blog/comments"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/blog/comments`


<!-- END_71c723fff2ae8b3c0253e5385ce64af1 -->

<!-- START_c4fca8a338654d7ef797d6760698600a -->
## api/profile/modules/status
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/profile/modules/status',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/profile/modules/status'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/profile/modules/status"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/profile/modules/status`


<!-- END_c4fca8a338654d7ef797d6760698600a -->

<!-- START_b6eb71d062ec96f770d25aa9bc86e4fe -->
## api/profile/modules/information
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/profile/modules/information',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/profile/modules/information'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/profile/modules/information"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/profile/modules/information`


<!-- END_b6eb71d062ec96f770d25aa9bc86e4fe -->

<!-- START_f66ced426ac187e03c8f2e14577fbbf8 -->
## api/profile/my-articles
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/profile/my-articles',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/profile/my-articles'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/profile/my-articles"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/profile/my-articles`


<!-- END_f66ced426ac187e03c8f2e14577fbbf8 -->

<!-- START_dbdbe2da259813830e01d32cbcbf3d66 -->
## api/profile/activity
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/profile/activity',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/profile/activity'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/profile/activity"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/profile/activity`


<!-- END_dbdbe2da259813830e01d32cbcbf3d66 -->

<!-- START_709168414b9397be69cf86add11b8668 -->
## api/profile/my-articles/sort
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/profile/my-articles/sort',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/profile/my-articles/sort'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/profile/my-articles/sort"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/profile/my-articles/sort`


<!-- END_709168414b9397be69cf86add11b8668 -->

<!-- START_50830aa1ce4b18c2d44dd0e99abe8819 -->
## api/profile/sessions
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/profile/sessions',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/profile/sessions'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/profile/sessions"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/profile/sessions`


<!-- END_50830aa1ce4b18c2d44dd0e99abe8819 -->

<!-- START_f46d81f23ec73b4fa1c19359d1843ba3 -->
## api/subscriptions
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/subscriptions',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/subscriptions'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/subscriptions"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/subscriptions`


<!-- END_f46d81f23ec73b4fa1c19359d1843ba3 -->

<!-- START_a772a34efd493b3a47f35b0a529012ea -->
## api/subscribe/section
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/subscribe/section',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/subscribe/section'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/subscribe/section"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/subscribe/section`


<!-- END_a772a34efd493b3a47f35b0a529012ea -->

<!-- START_fd02be421e27b50332ece01f74d41fe4 -->
## api/subscribe/article
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/subscribe/article',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/subscribe/article'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/subscribe/article"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/subscribe/article`


<!-- END_fd02be421e27b50332ece01f74d41fe4 -->

<!-- START_07f891c3dd25324cea3652eb1308c19a -->
## api/subscribe/user
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/subscribe/user',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/subscribe/user'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/subscribe/user"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/subscribe/user`


<!-- END_07f891c3dd25324cea3652eb1308c19a -->

<!-- START_1e2f5b17efdbb9ef6f0979f1f4f3c3e8 -->
## api/unsubscribe/section
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/unsubscribe/section',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/unsubscribe/section'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/unsubscribe/section"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/unsubscribe/section`


<!-- END_1e2f5b17efdbb9ef6f0979f1f4f3c3e8 -->

<!-- START_11e09ec00302b7764fc25e0f6d501327 -->
## api/unsubscribe/article
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/unsubscribe/article',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/unsubscribe/article'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/unsubscribe/article"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/unsubscribe/article`


<!-- END_11e09ec00302b7764fc25e0f6d501327 -->

<!-- START_997019646880dd4527ba57f49501c161 -->
## api/unsubscribe/user
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/unsubscribe/user',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/unsubscribe/user'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/unsubscribe/user"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/unsubscribe/user`


<!-- END_997019646880dd4527ba57f49501c161 -->

<!-- START_2dcff94b2ce883ac261fe57a6ec97c98 -->
## section/{section}-{id}/trash
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/section/1/trash',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/section/1/trash'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/section/1/trash"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
null
```

### HTTP Request
`GET section/{section}-{id}/trash`


<!-- END_2dcff94b2ce883ac261fe57a6ec97c98 -->

<!-- START_e931520da739920643dea985cf1bd167 -->
## api/section/{section}-{id}/trash
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/section/1/trash',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/section/1/trash'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/section/1/trash"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
null
```

### HTTP Request
`GET api/section/{section}-{id}/trash`


<!-- END_e931520da739920643dea985cf1bd167 -->

<!-- START_6699b064264d50440561df2d6f461b5d -->
## api/trash
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/trash',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/trash'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/trash"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/trash`


<!-- END_6699b064264d50440561df2d6f461b5d -->

<!-- START_b58f3d38ca3045ef7841f39b946e939b -->
## api/trash/sections/mass_delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/trash/sections/mass_delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/trash/sections/mass_delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/trash/sections/mass_delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/trash/sections/mass_delete`


<!-- END_b58f3d38ca3045ef7841f39b946e939b -->

<!-- START_e3dd7b9d01880538bed98046fb900f4f -->
## api/trash/articles/mass_delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/trash/articles/mass_delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/trash/articles/mass_delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/trash/articles/mass_delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/trash/articles/mass_delete`


<!-- END_e3dd7b9d01880538bed98046fb900f4f -->

<!-- START_5710b05b707cde3e007fc31b500f80da -->
## api/trash/delete_forever
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/trash/delete_forever',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/trash/delete_forever'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/trash/delete_forever"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/trash/delete_forever`


<!-- END_5710b05b707cde3e007fc31b500f80da -->

<!-- START_16f2e68abc80d3b05d8afa0e80587311 -->
## api/trash/undelete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/trash/undelete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/trash/undelete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/trash/undelete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/trash/undelete`


<!-- END_16f2e68abc80d3b05d8afa0e80587311 -->

<!-- START_8472c45d90cc25c18ea37dc1b3b24cad -->
## api/trash/show/{id}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/trash/show/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/trash/show/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/trash/show/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/trash/show/{id}`


<!-- END_8472c45d90cc25c18ea37dc1b3b24cad -->

<!-- START_98edfd75b62c5861a4ad3e7c0eb552a5 -->
## api/templates/form
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/templates/form',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/templates/form'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/templates/form"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/templates/form`


<!-- END_98edfd75b62c5861a4ad3e7c0eb552a5 -->

<!-- START_f6db289ece29ed5ef15aee3db3617e44 -->
## api/templates/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/templates/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/templates/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/templates/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/templates/update`


<!-- END_f6db289ece29ed5ef15aee3db3617e44 -->

<!-- START_ef0e832b7fa040fbb06ba4a9cb3c9d8b -->
## api/colors/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/colors/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/colors/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/colors/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/colors/edit`


<!-- END_ef0e832b7fa040fbb06ba4a9cb3c9d8b -->

<!-- START_0fdb9fd6d23e54b31dd725bd3a1bd8b3 -->
## api/colors/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/colors/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/colors/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/colors/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/colors/update`


<!-- END_0fdb9fd6d23e54b31dd725bd3a1bd8b3 -->

<!-- START_f7c31c06559420a8d5fcd5f510d4e061 -->
## api/colors/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/colors/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/colors/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/colors/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/colors/create`


<!-- END_f7c31c06559420a8d5fcd5f510d4e061 -->

<!-- START_f39253452feb41b342d242cb5f2d1768 -->
## api/colors/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/colors/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/colors/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/colors/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/colors/delete`


<!-- END_f39253452feb41b342d242cb5f2d1768 -->

<!-- START_7400bb6dce403364759f4e6af42a6215 -->
## api/language/form
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/language/form',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/language/form'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/language/form"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/language/form`


<!-- END_7400bb6dce403364759f4e6af42a6215 -->

<!-- START_d0c027fb6f42115a4635524d830fc5d6 -->
## api/language/add_domain
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/language/add_domain',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/language/add_domain'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/language/add_domain"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/language/add_domain`


<!-- END_d0c027fb6f42115a4635524d830fc5d6 -->

<!-- START_ba2db432241bce5bf44bcb3cc7cd18fd -->
## api/language/add
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/language/add',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/language/add'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/language/add"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/language/add`


<!-- END_ba2db432241bce5bf44bcb3cc7cd18fd -->

<!-- START_e4de033a55da3ec1112302085bda00b8 -->
## api/object_relations/list
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/object_relations/list',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/object_relations/list'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/object_relations/list"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/object_relations/list`


<!-- END_e4de033a55da3ec1112302085bda00b8 -->

<!-- START_1a13e1a1796f5dd51ef42d5164fc789e -->
## api/object_relations/get_card
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/object_relations/get_card',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/object_relations/get_card'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/object_relations/get_card"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/object_relations/get_card`


<!-- END_1a13e1a1796f5dd51ef42d5164fc789e -->

<!-- START_19317ebad5893da8b9904cb69f79c0f3 -->
## api/object_relations/connect
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/object_relations/connect',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/object_relations/connect'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/object_relations/connect"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/object_relations/connect`


<!-- END_19317ebad5893da8b9904cb69f79c0f3 -->

<!-- START_87b39aa75e6047d42c50ab28aa29b8b5 -->
## api/object_relations/disconnect
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/object_relations/disconnect',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/object_relations/disconnect'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/object_relations/disconnect"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/object_relations/disconnect`


<!-- END_87b39aa75e6047d42c50ab28aa29b8b5 -->

<!-- START_8d043d91ab20be3a9627cffedcb1f58a -->
## cards
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/cards',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/cards'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/cards"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET cards`


<!-- END_8d043d91ab20be3a9627cffedcb1f58a -->

<!-- START_630e48bbb7ccb3947a88200a6fac06d2 -->
## catalogs
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/catalogs',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/catalogs'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/catalogs"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET catalogs`


<!-- END_630e48bbb7ccb3947a88200a6fac06d2 -->

<!-- START_01fae47107b3240d6ec52d39558724e0 -->
## catalogs/{url}-{id}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/catalogs/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/catalogs/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/catalogs/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
null
```

### HTTP Request
`GET catalogs/{url}-{id}`


<!-- END_01fae47107b3240d6ec52d39558724e0 -->

<!-- START_b3365a5c9d62f424e416e6bebf98af71 -->
## card/{name}-{id}.html
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/card/1.html',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/card/1.html'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/card/1.html"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
null
```

### HTTP Request
`GET card/{name}-{id}.html`


<!-- END_b3365a5c9d62f424e416e6bebf98af71 -->

<!-- START_51412421451358a2bc47d101b61feeeb -->
## catalog
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/catalog',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/catalog'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/catalog"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET catalog`


<!-- END_51412421451358a2bc47d101b61feeeb -->

<!-- START_2bcd15cdf4917bb662bd8ac748d74451 -->
## catalog/{url}-{id}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/catalog/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/catalog/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/catalog/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
null
```

### HTTP Request
`GET catalog/{url}-{id}`


<!-- END_2bcd15cdf4917bb662bd8ac748d74451 -->

<!-- START_3f08e302dc370b41c78478c2a19b99d8 -->
## api/objects/list
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/objects/list',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/objects/list'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/objects/list"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/objects/list`


<!-- END_3f08e302dc370b41c78478c2a19b99d8 -->

<!-- START_b4b473e22fd01665c4b9e9746321b976 -->
## api/objects/get_data
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/objects/get_data',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/objects/get_data'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/objects/get_data"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/objects/get_data`


<!-- END_b4b473e22fd01665c4b9e9746321b976 -->

<!-- START_5007ea06c64ab24f4f293cd0a4c95f6e -->
## api/objects/catalog
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/objects/catalog',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/objects/catalog'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/objects/catalog"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/objects/catalog`


<!-- END_5007ea06c64ab24f4f293cd0a4c95f6e -->

<!-- START_45def099ef0f5ed3b19675e915c3aaac -->
## api/objects/filter
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/objects/filter',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/objects/filter'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/objects/filter"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/objects/filter`


<!-- END_45def099ef0f5ed3b19675e915c3aaac -->

<!-- START_2ad46d1716438af140ddc187585776f0 -->
## api/objects/copy_card
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/objects/copy_card',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/objects/copy_card'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/objects/copy_card"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/objects/copy_card`


<!-- END_2ad46d1716438af140ddc187585776f0 -->

<!-- START_483a9f834aea1ad34a60000e9d7dddca -->
## api/objects/search
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/objects/search',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/objects/search'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/objects/search"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/objects/search`

`POST api/objects/search`

`PUT api/objects/search`

`PATCH api/objects/search`

`DELETE api/objects/search`

`OPTIONS api/objects/search`


<!-- END_483a9f834aea1ad34a60000e9d7dddca -->

<!-- START_b5067e11500333a825e82c4b6ee03210 -->
## api/objects/search_card
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/objects/search_card',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/objects/search_card'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/objects/search_card"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/objects/search_card`


<!-- END_b5067e11500333a825e82c4b6ee03210 -->

<!-- START_4bf8e694beab1d222d0d1f08a5dc63ae -->
## api/objects/view_card/{id}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/objects/view_card/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/objects/view_card/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/objects/view_card/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/objects/view_card/{id}`


<!-- END_4bf8e694beab1d222d0d1f08a5dc63ae -->

<!-- START_6de7f06d39ef6b510f79208043ff347d -->
## api/objects/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/objects/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/objects/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/objects/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/objects/update`


<!-- END_6de7f06d39ef6b510f79208043ff347d -->

<!-- START_c666d377190cd9a6a29575e934cffc71 -->
## api/objects/create_catalog
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/objects/create_catalog',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/objects/create_catalog'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/objects/create_catalog"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/objects/create_catalog`


<!-- END_c666d377190cd9a6a29575e934cffc71 -->

<!-- START_4c5a396095b1e26c661dd0dcd4a4713b -->
## api/objects/form/{oId}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/objects/form/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/objects/form/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/objects/form/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/objects/form/{oId}`


<!-- END_4c5a396095b1e26c661dd0dcd4a4713b -->

<!-- START_6b344730056e236599d5168a774655b5 -->
## api/objects/save_form/{oId}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/objects/save_form/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/objects/save_form/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/objects/save_form/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/objects/save_form/{oId}`


<!-- END_6b344730056e236599d5168a774655b5 -->

<!-- START_cbe6339360d05ecd9f556777d5579cd4 -->
## api/objects/delete/{oId}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/objects/delete/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/objects/delete/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/objects/delete/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/objects/delete/{oId}`


<!-- END_cbe6339360d05ecd9f556777d5579cd4 -->

<!-- START_a9ba2be789774b4f82c9d265b6903ab1 -->
## api/objects
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/objects',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/objects'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/objects"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/objects`


<!-- END_a9ba2be789774b4f82c9d265b6903ab1 -->

<!-- START_2979ba9336fad19c2f8f1755c5587196 -->
## api/objects/data
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/objects/data',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/objects/data'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/objects/data"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/objects/data`


<!-- END_2979ba9336fad19c2f8f1755c5587196 -->

<!-- START_e5532ce5db91df476a7ac44e89d22741 -->
## api/objects/cards
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/objects/cards',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/objects/cards'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/objects/cards"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/objects/cards`


<!-- END_e5532ce5db91df476a7ac44e89d22741 -->

<!-- START_7334c5d00c4325809e001ed05398c6ee -->
## api/objects/catalogs
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/objects/catalogs',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/objects/catalogs'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/objects/catalogs"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/objects/catalogs`


<!-- END_7334c5d00c4325809e001ed05398c6ee -->

<!-- START_c42242efd7855ea30c2189f64ff2642c -->
## api/objects/catalogs/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/objects/catalogs/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/objects/catalogs/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/objects/catalogs/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/objects/catalogs/delete`


<!-- END_c42242efd7855ea30c2189f64ff2642c -->

<!-- START_8a8a3046ef238501fee31c431a82ce97 -->
## api/objects/catalogs/{url}-{id}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/objects/catalogs/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/objects/catalogs/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/objects/catalogs/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
null
```

### HTTP Request
`GET api/objects/catalogs/{url}-{id}`


<!-- END_8a8a3046ef238501fee31c431a82ce97 -->

<!-- START_8dc59f9a264671262d96ace986026646 -->
## api/robots/show
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/robots/show',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/robots/show'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/robots/show"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/robots/show`


<!-- END_8dc59f9a264671262d96ace986026646 -->

<!-- START_cef6e587b9be79bf027563902c68a252 -->
## api/robots/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/robots/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/robots/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/robots/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/robots/edit`


<!-- END_cef6e587b9be79bf027563902c68a252 -->

<!-- START_ce58b2b01b71c47a52c5fb13efe043b3 -->
## api/currency/convert
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/currency/convert',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/currency/convert'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/currency/convert"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/currency/convert`


<!-- END_ce58b2b01b71c47a52c5fb13efe043b3 -->

<!-- START_9c49c7ed87d8e0e11b23363722d9ad11 -->
## api/balance/add
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/balance/add',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/balance/add'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/balance/add"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/balance/add`


<!-- END_9c49c7ed87d8e0e11b23363722d9ad11 -->

<!-- START_31b1a8f21f45976bf1664ce920fce68b -->
## api/balance/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/balance/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/balance/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/balance/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/balance/update`


<!-- END_31b1a8f21f45976bf1664ce920fce68b -->

<!-- START_c1414ad6990a9b6231376022f647cb61 -->
## api/tariffs/pay
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/tariffs/pay',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/tariffs/pay'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/tariffs/pay"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/tariffs/pay`


<!-- END_c1414ad6990a9b6231376022f647cb61 -->

<!-- START_c2fa28646514b51d84a92a347db489af -->
## api/tariffs/info
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/tariffs/info',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/tariffs/info'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/tariffs/info"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/tariffs/info`


<!-- END_c2fa28646514b51d84a92a347db489af -->

<!-- START_d0dfba3039c845d0a785a5d6f2556ee6 -->
## api/tariffs
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/tariffs',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/tariffs'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/tariffs"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/tariffs`


<!-- END_d0dfba3039c845d0a785a5d6f2556ee6 -->

<!-- START_af1298e56dd857ae3a965700708717db -->
## api/services/pay
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/services/pay',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/services/pay'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/services/pay"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/services/pay`


<!-- END_af1298e56dd857ae3a965700708717db -->

<!-- START_d4af3f8645d6e934beb0738e48f47ef4 -->
## api/services/info
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/services/info',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/services/info'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/services/info"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/services/info`


<!-- END_d4af3f8645d6e934beb0738e48f47ef4 -->

<!-- START_28d59edef28695e3ed657984d8376bee -->
## api/billing/history
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/billing/history',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/billing/history'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/billing/history"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/billing/history`


<!-- END_28d59edef28695e3ed657984d8376bee -->

<!-- START_b4d504a6dbe20fdf7e2330758dad7d1c -->
## api/subscriptions/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/subscriptions/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/subscriptions/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/subscriptions/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/subscriptions/delete`


<!-- END_b4d504a6dbe20fdf7e2330758dad7d1c -->

<!-- START_648624a43ca7ac9fbd5688dfaf08bf39 -->
## api/profile/services
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/profile/services',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/profile/services'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/profile/services"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/profile/services`


<!-- END_648624a43ca7ac9fbd5688dfaf08bf39 -->

<!-- START_56fccd1219fb0a78a7462b7fde203fdd -->
## api/profile/tariffs
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/profile/tariffs',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/profile/tariffs'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/profile/tariffs"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/profile/tariffs`


<!-- END_56fccd1219fb0a78a7462b7fde203fdd -->

<!-- START_c07c8d83cd844a12516c3c5355e08399 -->
## api/profile/sites
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/profile/sites',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/profile/sites'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/profile/sites"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/profile/sites`


<!-- END_c07c8d83cd844a12516c3c5355e08399 -->

<!-- START_9f863bad346eea2b9fe35f17fec97bc7 -->
## billing/balance
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/billing/balance',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/billing/balance'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/billing/balance"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET billing/balance`


<!-- END_9f863bad346eea2b9fe35f17fec97bc7 -->

<!-- START_bfb2f3480c6efa30888417d870249ec8 -->
## billing/history
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/billing/history',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/billing/history'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/billing/history"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET billing/history`


<!-- END_bfb2f3480c6efa30888417d870249ec8 -->

<!-- START_609dcd77def39753bc84434fc0b89283 -->
## billing/tariffs
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/billing/tariffs',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/billing/tariffs'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/billing/tariffs"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET billing/tariffs`


<!-- END_609dcd77def39753bc84434fc0b89283 -->

<!-- START_0a0b023d12c438bf9377901940869a5b -->
## billing/services
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/billing/services',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/billing/services'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/billing/services"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET billing/services`


<!-- END_0a0b023d12c438bf9377901940869a5b -->

<!-- START_d28ee83a252b50be2ead56b2dbb9da2b -->
## billing/dashboard
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/billing/dashboard',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/billing/dashboard'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/billing/dashboard"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET billing/dashboard`


<!-- END_d28ee83a252b50be2ead56b2dbb9da2b -->

<!-- START_5be06902437150233abc097c08a62e85 -->
## balance/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/balance/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/balance/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/balance/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET balance/update`


<!-- END_5be06902437150233abc097c08a62e85 -->

<!-- START_4a565484d7cf52c6c75cba8a9ce5a135 -->
## api/currency/convert_to_points
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/currency/convert_to_points',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/currency/convert_to_points'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/currency/convert_to_points"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/currency/convert_to_points`


<!-- END_4a565484d7cf52c6c75cba8a9ce5a135 -->

<!-- START_c9173f22c25f0b5343301eb1c5a1dd62 -->
## api/currency/form
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/currency/form',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/currency/form'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/currency/form"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/currency/form`


<!-- END_c9173f22c25f0b5343301eb1c5a1dd62 -->

<!-- START_67618d299c9313da1c091e077e3727b5 -->
## api/currency/get_discounts
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/currency/get_discounts',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/currency/get_discounts'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/currency/get_discounts"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/currency/get_discounts`


<!-- END_67618d299c9313da1c091e077e3727b5 -->

<!-- START_b055818a6010ea77062ea8f0e197e05a -->
## api/discount
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/discount',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/discount'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/discount"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/discount`


<!-- END_b055818a6010ea77062ea8f0e197e05a -->

<!-- START_ea84a78219560615c4ff37e1fa296629 -->
## api/services
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/services',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/services'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/services"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/services`


<!-- END_ea84a78219560615c4ff37e1fa296629 -->

<!-- START_ba05cb3a11667fbd2926fcfc72905d8a -->
## projects
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/projects',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/projects'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/projects"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET projects`


<!-- END_ba05cb3a11667fbd2926fcfc72905d8a -->

<!-- START_85d8ea4c9c2ce6bb50fc049cbd007a92 -->
## api/announcement/form
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/announcement/form',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/announcement/form'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/announcement/form"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/announcement/form`


<!-- END_85d8ea4c9c2ce6bb50fc049cbd007a92 -->

<!-- START_1c1a30e607f5a016ec9ee1e998b762d9 -->
## api/announcement/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/announcement/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/announcement/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/announcement/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/announcement/create`


<!-- END_1c1a30e607f5a016ec9ee1e998b762d9 -->

<!-- START_b728e274cd11aeb45ebb7b3701c59e07 -->
## api/announcement/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/announcement/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/announcement/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/announcement/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/announcement/update`


<!-- END_b728e274cd11aeb45ebb7b3701c59e07 -->

<!-- START_a1e22a9f6234a684980c1162b72b656e -->
## api/announcement/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/announcement/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/announcement/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/announcement/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/announcement/delete`


<!-- END_a1e22a9f6234a684980c1162b72b656e -->

<!-- START_8929652a20f0b0b5ba139f61b63d69d1 -->
## api/announcement/search
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/announcement/search',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/announcement/search'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/announcement/search"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/announcement/search`


<!-- END_8929652a20f0b0b5ba139f61b63d69d1 -->

<!-- START_543b0b80e8dc51d2d3ad7e2a327eed26 -->
## api/contacts
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/contacts',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/contacts'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/contacts"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/contacts`


<!-- END_543b0b80e8dc51d2d3ad7e2a327eed26 -->

<!-- START_baf680a48bc129f27432c80ec8921433 -->
## api/feedback
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/feedback',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/feedback'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/feedback"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/feedback`


<!-- END_baf680a48bc129f27432c80ec8921433 -->

<!-- START_086cd2882c6bef83993f6d1149ef339b -->
## api/feedback/log
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/feedback/log',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/feedback/log'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/feedback/log"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/feedback/log`


<!-- END_086cd2882c6bef83993f6d1149ef339b -->

<!-- START_76cecc331d929964bf8588db9cdcab51 -->
## api/feedback/fields
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/feedback/fields',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/feedback/fields'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/feedback/fields"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/feedback/fields`


<!-- END_76cecc331d929964bf8588db9cdcab51 -->

<!-- START_aff71564981b5476730a3bebde82db7b -->
## api/orders/list
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/orders/list',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/orders/list'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/orders/list"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/orders/list`


<!-- END_aff71564981b5476730a3bebde82db7b -->

<!-- START_d368fda514f16ed74203ad580f06c2ef -->
## api/orders/search
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/orders/search',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/orders/search'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/orders/search"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/orders/search`


<!-- END_d368fda514f16ed74203ad580f06c2ef -->

<!-- START_e27c16fa6d4d6eeec962e3f9d13e5819 -->
## api/orders/order
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/orders/order',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/orders/order'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/orders/order"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/orders/order`


<!-- END_e27c16fa6d4d6eeec962e3f9d13e5819 -->

<!-- START_2acdb0d116d7a26978521cc2fe48c019 -->
## api/orders/statuses
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/orders/statuses',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/orders/statuses'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/orders/statuses"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/orders/statuses`


<!-- END_2acdb0d116d7a26978521cc2fe48c019 -->

<!-- START_315c2d10ce3adafcc9cf1b870f59eeff -->
## api/orders/change-status
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/orders/change-status',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/orders/change-status'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/orders/change-status"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/orders/change-status`


<!-- END_315c2d10ce3adafcc9cf1b870f59eeff -->

<!-- START_9cfb4b91305c7348966c4f0cc228c528 -->
## api/orders/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/orders/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/orders/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/orders/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/orders/delete`


<!-- END_9cfb4b91305c7348966c4f0cc228c528 -->

<!-- START_4a5d9a8dcbc90eeb1ad729465685f373 -->
## api/orders/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/orders/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/orders/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/orders/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/orders/update`


<!-- END_4a5d9a8dcbc90eeb1ad729465685f373 -->

<!-- START_468890dd997637115f05b0f1f79099d5 -->
## api/orders/user-list
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/orders/user-list',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/orders/user-list'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/orders/user-list"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/orders/user-list`


<!-- END_468890dd997637115f05b0f1f79099d5 -->

<!-- START_17ab70a3f37d2030e427f295c0d81f89 -->
## api/orders/order/{id}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/orders/order/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/orders/order/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/orders/order/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/orders/order/{id}`


<!-- END_17ab70a3f37d2030e427f295c0d81f89 -->

<!-- START_489280febe97aa44df4f43558d45fdf3 -->
## contacts
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/contacts',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/contacts'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/contacts"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET contacts`


<!-- END_489280febe97aa44df4f43558d45fdf3 -->

<!-- START_f453d442cbe270ed50c2def3a3416115 -->
## about
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/about',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/about'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/about"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET about`


<!-- END_f453d442cbe270ed50c2def3a3416115 -->

<!-- START_47f7fbb6bf98ef4cdc54b10f03cb3bdd -->
## profile
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/profile',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/profile'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/profile"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET profile`


<!-- END_47f7fbb6bf98ef4cdc54b10f03cb3bdd -->

<!-- START_7dccab8fd26cba956fd08b514633b1c2 -->
## profile/articles
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/profile/articles',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/profile/articles'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/profile/articles"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET profile/articles`


<!-- END_7dccab8fd26cba956fd08b514633b1c2 -->

<!-- START_d1e4da562ad63242635ece758cc29303 -->
## profile/sections
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/profile/sections',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/profile/sections'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/profile/sections"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET profile/sections`


<!-- END_d1e4da562ad63242635ece758cc29303 -->

<!-- START_253459d1c8c43295497067055cdabfe0 -->
## profile/security
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/profile/security',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/profile/security'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/profile/security"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET profile/security`


<!-- END_253459d1c8c43295497067055cdabfe0 -->

<!-- START_a1f94d60c0d20ca80d3060dcbe0ae5b1 -->
## storage
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/storage',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/storage'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/storage"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET storage`


<!-- END_a1f94d60c0d20ca80d3060dcbe0ae5b1 -->

<!-- START_53be1e9e10a08458929a2e0ea70ddb86 -->
## /
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET /`


<!-- END_53be1e9e10a08458929a2e0ea70ddb86 -->

<!-- START_d7b7952e7fdddc07c978c9bdaf757acf -->
## api/register
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/register',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/register'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/register"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/register`


<!-- END_d7b7952e7fdddc07c978c9bdaf757acf -->

<!-- START_e5a580916dc8390a4a87a2b48a8415dd -->
## api/register/v2
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/register/v2',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/register/v2'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/register/v2"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/register/v2`


<!-- END_e5a580916dc8390a4a87a2b48a8415dd -->

<!-- START_c3fa189a6c95ca36ad6ac4791a873d23 -->
## api/login
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/login',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/login'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/login"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/login`


<!-- END_c3fa189a6c95ca36ad6ac4791a873d23 -->

<!-- START_23b505da6bd78461153685e069303daa -->
## api/logged
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/logged',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/logged'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/logged"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/logged`


<!-- END_23b505da6bd78461153685e069303daa -->

<!-- START_19476cafcbd69e516e7b10875be0cb14 -->
## api/profile/save
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/profile/save',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/profile/save'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/profile/save"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/profile/save`


<!-- END_19476cafcbd69e516e7b10875be0cb14 -->

<!-- START_e66797c3298f6ac9d4e00cac85685002 -->
## l/{id}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/l/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/l/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/l/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET l/{id}`


<!-- END_e66797c3298f6ac9d4e00cac85685002 -->

<!-- START_f4dc97d9494e371a1876f661269bc543 -->
## api/rating/article/{id}/set
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/rating/article/1/set',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/rating/article/1/set'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/rating/article/1/set"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/rating/article/{id}/set`


<!-- END_f4dc97d9494e371a1876f661269bc543 -->

<!-- START_22fcb5e407b57a6087e08092cade12a8 -->
## api/rating/comment/{id}/set
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/rating/comment/1/set',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/rating/comment/1/set'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/rating/comment/1/set"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/rating/comment/{id}/set`


<!-- END_22fcb5e407b57a6087e08092cade12a8 -->

<!-- START_231ca96d1e8d6c716f088f1d390d6f8d -->
## api/rating/article/{id}/unvote
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/rating/article/1/unvote',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/rating/article/1/unvote'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/rating/article/1/unvote"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/rating/article/{id}/unvote`


<!-- END_231ca96d1e8d6c716f088f1d390d6f8d -->

<!-- START_5a3e170db7d481bce0ffdfdf18551b0c -->
## api/rating/comment/{id}/unvote
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/rating/comment/1/unvote',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/rating/comment/1/unvote'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/rating/comment/1/unvote"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/rating/comment/{id}/unvote`


<!-- END_5a3e170db7d481bce0ffdfdf18551b0c -->

<!-- START_21f4a17638e48892860f9c32d5e5985b -->
## api/article_groups/search_group
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/article_groups/search_group',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/article_groups/search_group'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/article_groups/search_group"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/article_groups/search_group`


<!-- END_21f4a17638e48892860f9c32d5e5985b -->

<!-- START_2adc85538d01a2e556fd5f97abbde6d3 -->
## api/article_groups/search_article
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/article_groups/search_article',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/article_groups/search_article'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/article_groups/search_article"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/article_groups/search_article`


<!-- END_2adc85538d01a2e556fd5f97abbde6d3 -->

<!-- START_670ee9e3ba34e9f76b9e6a64961102f6 -->
## api/article_groups/delete_article
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/article_groups/delete_article',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/article_groups/delete_article'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/article_groups/delete_article"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/article_groups/delete_article`


<!-- END_670ee9e3ba34e9f76b9e6a64961102f6 -->

<!-- START_ae746b7e485a9181bc833a3ee83b8b32 -->
## api/article_groups/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/article_groups/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/article_groups/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/article_groups/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/article_groups/delete`


<!-- END_ae746b7e485a9181bc833a3ee83b8b32 -->

<!-- START_6cea5c83e64b45d78ae30115d3bc94d7 -->
## api/article_groups/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/article_groups/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/article_groups/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/article_groups/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/article_groups/create`


<!-- END_6cea5c83e64b45d78ae30115d3bc94d7 -->

<!-- START_1b7cd3d202742361d1207059a1e87dfc -->
## api/article_groups/create_article
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/article_groups/create_article',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/article_groups/create_article'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/article_groups/create_article"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/article_groups/create_article`


<!-- END_1b7cd3d202742361d1207059a1e87dfc -->

<!-- START_4109770b3f85bd7e0ecf753363bc3ac8 -->
## api/modules/article/sort
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/article/sort',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/article/sort'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/article/sort"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/article/sort`


<!-- END_4109770b3f85bd7e0ecf753363bc3ac8 -->

<!-- START_7cc15afb50353cae8a8c3417f20fb55e -->
## api/modules/feedback/send
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/feedback/send',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/feedback/send'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/feedback/send"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/feedback/send`


<!-- END_7cc15afb50353cae8a8c3417f20fb55e -->

<!-- START_2d236486790b63811d53752b8eab7e1c -->
## api/modules/section/sort
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/section/sort',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/section/sort'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/section/sort"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/section/sort`


<!-- END_2d236486790b63811d53752b8eab7e1c -->

<!-- START_d14ad207dc5d28954314c34f3ae04827 -->
## api/modules/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/delete`


<!-- END_d14ad207dc5d28954314c34f3ae04827 -->

<!-- START_a1da52f50d95225ce7d6082f8cfd0c5c -->
## api/modules/active
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/active',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/active'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/active"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/active`


<!-- END_a1da52f50d95225ce7d6082f8cfd0c5c -->

<!-- START_683686b66a2974a3848a399d94f88be3 -->
## api/modules/animation
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/animation',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/animation'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/animation"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/animation`


<!-- END_683686b66a2974a3848a399d94f88be3 -->

<!-- START_e3c579029c2376281c5d4198d6bdb19b -->
## api/modules/menu/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/menu/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/menu/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/menu/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/menu/create`


<!-- END_e3c579029c2376281c5d4198d6bdb19b -->

<!-- START_3419908e0132420097df1af44c382f9d -->
## api/modules/menu/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/menu/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/menu/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/menu/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/menu/edit`


<!-- END_3419908e0132420097df1af44c382f9d -->

<!-- START_69b9080926cdd574f1c64cfb5de2b1ba -->
## api/modules/menu/sort
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/menu/sort',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/menu/sort'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/menu/sort"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/menu/sort`


<!-- END_69b9080926cdd574f1c64cfb5de2b1ba -->

<!-- START_b5e6a1965dabce21817f7de09d68d2ad -->
## api/modules/menu/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/menu/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/menu/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/menu/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/menu/delete`


<!-- END_b5e6a1965dabce21817f7de09d68d2ad -->

<!-- START_a25989caa262fd0d9dfd0da221f9261a -->
## api/modules/menu/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/menu/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/menu/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/menu/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/menu/update`


<!-- END_a25989caa262fd0d9dfd0da221f9261a -->

<!-- START_618ba2ccae71f3be07cdf352e10d600a -->
## api/modules/menu/form
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/menu/form',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/menu/form'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/menu/form"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/menu/form`


<!-- END_618ba2ccae71f3be07cdf352e10d600a -->

<!-- START_cd5bfbd8c06c82b6f022d2af3d254133 -->
## api/modules/menu_advanced/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/menu_advanced/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/menu_advanced/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/menu_advanced/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/menu_advanced/create`


<!-- END_cd5bfbd8c06c82b6f022d2af3d254133 -->

<!-- START_e68be1edabc80386188524cfe9158d09 -->
## api/modules/menu_advanced/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/menu_advanced/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/menu_advanced/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/menu_advanced/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/menu_advanced/edit`


<!-- END_e68be1edabc80386188524cfe9158d09 -->

<!-- START_b7c226026bbd354b4dba1e05a9db0a86 -->
## api/modules/menu_advanced/sort
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/menu_advanced/sort',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/menu_advanced/sort'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/menu_advanced/sort"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/menu_advanced/sort`


<!-- END_b7c226026bbd354b4dba1e05a9db0a86 -->

<!-- START_c7a3b67d8ed39f071a855d21f4fe6758 -->
## api/modules/menu_advanced/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/menu_advanced/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/menu_advanced/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/menu_advanced/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/menu_advanced/delete`


<!-- END_c7a3b67d8ed39f071a855d21f4fe6758 -->

<!-- START_94f3997d853f3d850bf6a3f382436d19 -->
## api/modules/menu_advanced/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/menu_advanced/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/menu_advanced/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/menu_advanced/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/menu_advanced/update`


<!-- END_94f3997d853f3d850bf6a3f382436d19 -->

<!-- START_ed4d94f01a8d0553c30f7991231e1b81 -->
## api/modules/menu_advanced/form
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/menu_advanced/form',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/menu_advanced/form'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/menu_advanced/form"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/menu_advanced/form`


<!-- END_ed4d94f01a8d0553c30f7991231e1b81 -->

<!-- START_4e4b84405746c8bba87fbba5895b28e4 -->
## api/modules/footer_menu/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/footer_menu/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/footer_menu/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/footer_menu/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/footer_menu/create`


<!-- END_4e4b84405746c8bba87fbba5895b28e4 -->

<!-- START_f35f1fb028d21f3ed71f85c958a030d6 -->
## api/modules/footer_menu/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/footer_menu/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/footer_menu/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/footer_menu/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/footer_menu/edit`


<!-- END_f35f1fb028d21f3ed71f85c958a030d6 -->

<!-- START_9a976b644ea93d4ed8647aa85ad1d075 -->
## api/modules/footer_menu/sort
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/footer_menu/sort',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/footer_menu/sort'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/footer_menu/sort"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/footer_menu/sort`


<!-- END_9a976b644ea93d4ed8647aa85ad1d075 -->

<!-- START_cc9d6b4dd7e0780a5597e8522d7c75c7 -->
## api/modules/footer_menu/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/footer_menu/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/footer_menu/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/footer_menu/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/footer_menu/delete`


<!-- END_cc9d6b4dd7e0780a5597e8522d7c75c7 -->

<!-- START_b1f1f954eedf95e03fbea6ac083d9bf6 -->
## api/modules/footer_menu/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/footer_menu/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/footer_menu/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/footer_menu/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/footer_menu/update`


<!-- END_b1f1f954eedf95e03fbea6ac083d9bf6 -->

<!-- START_d9011e3d76589074a731f45b6a215191 -->
## api/modules/footer_menu/form
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/footer_menu/form',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/footer_menu/form'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/footer_menu/form"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/footer_menu/form`


<!-- END_d9011e3d76589074a731f45b6a215191 -->

<!-- START_6a382cc861b6d412d9e566de94f78c7f -->
## api/modules/text/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/text/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/text/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/text/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/text/create`


<!-- END_6a382cc861b6d412d9e566de94f78c7f -->

<!-- START_2b853c5d498c7932a2f646dcd6898053 -->
## api/modules/text/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/text/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/text/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/text/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/text/edit`


<!-- END_2b853c5d498c7932a2f646dcd6898053 -->

<!-- START_ae6d0cb28fc590a7cce0fef0ba245971 -->
## api/modules/text/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/text/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/text/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/text/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/text/delete`


<!-- END_ae6d0cb28fc590a7cce0fef0ba245971 -->

<!-- START_2ade08ff7d690e6d0567cd658e74c0e7 -->
## api/modules/text/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/text/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/text/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/text/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/text/update`


<!-- END_2ade08ff7d690e6d0567cd658e74c0e7 -->

<!-- START_6fbb3dbd790e07717f458d13ab61c32b -->
## api/modules/text/form
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/text/form',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/text/form'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/text/form"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/text/form`


<!-- END_6fbb3dbd790e07717f458d13ab61c32b -->

<!-- START_a3e76dd92145a54e3a7ecb6b7037198f -->
## api/modules/catalog/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/catalog/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/catalog/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/catalog/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/catalog/create`


<!-- END_a3e76dd92145a54e3a7ecb6b7037198f -->

<!-- START_98050d844d1c7e9c9412b9e7ab173df2 -->
## api/modules/catalog/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/catalog/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/catalog/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/catalog/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/catalog/edit`


<!-- END_98050d844d1c7e9c9412b9e7ab173df2 -->

<!-- START_f2c4fcd2016eacea2bb5ea41d3dce6ad -->
## api/modules/catalog/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/catalog/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/catalog/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/catalog/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/catalog/delete`


<!-- END_f2c4fcd2016eacea2bb5ea41d3dce6ad -->

<!-- START_d8265057006db4a084f958bc3a5c0c4f -->
## api/modules/catalog/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/catalog/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/catalog/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/catalog/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/catalog/update`


<!-- END_d8265057006db4a084f958bc3a5c0c4f -->

<!-- START_a10b8afdf937cc383e55262b43c4be47 -->
## api/modules/catalog/get_filter_data
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/catalog/get_filter_data',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/catalog/get_filter_data'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/catalog/get_filter_data"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/catalog/get_filter_data`


<!-- END_a10b8afdf937cc383e55262b43c4be47 -->

<!-- START_d5988e75335fd39afd9f34dfedea94aa -->
## api/modules/catalog/form
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/catalog/form',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/catalog/form'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/catalog/form"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/catalog/form`


<!-- END_d5988e75335fd39afd9f34dfedea94aa -->

<!-- START_d5c4776a1da21fca169b6c3aa2624681 -->
## api/modules/information/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/information/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/information/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/information/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/information/create`


<!-- END_d5c4776a1da21fca169b6c3aa2624681 -->

<!-- START_3c99d0b0b9fe4065ce16ba454b1e1245 -->
## api/modules/information/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/information/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/information/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/information/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/information/edit`


<!-- END_3c99d0b0b9fe4065ce16ba454b1e1245 -->

<!-- START_ec66cdcdf0ef8ca472716323a2fbe2c6 -->
## api/modules/information/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/information/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/information/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/information/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/information/delete`


<!-- END_ec66cdcdf0ef8ca472716323a2fbe2c6 -->

<!-- START_abee82785a3f68619fe5f40931a07a86 -->
## api/modules/information/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/information/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/information/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/information/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/information/update`


<!-- END_abee82785a3f68619fe5f40931a07a86 -->

<!-- START_36da4971b465c3acc862aacf7d40226a -->
## api/modules/information/form
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/information/form',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/information/form'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/information/form"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/information/form`


<!-- END_36da4971b465c3acc862aacf7d40226a -->

<!-- START_df6b1e2221be4ef24df8abf94c0b684b -->
## api/modules/contacts/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/contacts/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/contacts/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/contacts/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/contacts/create`


<!-- END_df6b1e2221be4ef24df8abf94c0b684b -->

<!-- START_f340babc742217dea2c30089117260d1 -->
## api/modules/contacts/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/contacts/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/contacts/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/contacts/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/contacts/edit`


<!-- END_f340babc742217dea2c30089117260d1 -->

<!-- START_0dda40a8e665c6906d6182b119a4c58f -->
## api/modules/contacts/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/contacts/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/contacts/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/contacts/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/contacts/update`


<!-- END_0dda40a8e665c6906d6182b119a4c58f -->

<!-- START_0e4f0b628dd13afdc5e17fbfbf220fe6 -->
## api/modules/contacts/form
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/contacts/form',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/contacts/form'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/contacts/form"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/contacts/form`


<!-- END_0e4f0b628dd13afdc5e17fbfbf220fe6 -->

<!-- START_c4940c7bfe3ca2195290de6843fe60b3 -->
## api/modules/contacts/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/contacts/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/contacts/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/contacts/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/contacts/delete`


<!-- END_c4940c7bfe3ca2195290de6843fe60b3 -->

<!-- START_a2850d93a115dd1abfced70bd135a56c -->
## api/modules/socials/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/socials/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/socials/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/socials/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/socials/edit`


<!-- END_a2850d93a115dd1abfced70bd135a56c -->

<!-- START_ee5dec5abead518eef408484341fbb03 -->
## api/modules/socials/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/socials/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/socials/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/socials/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/socials/update`


<!-- END_ee5dec5abead518eef408484341fbb03 -->

<!-- START_5aa41566d625c634b5ae7586a2d6816c -->
## api/modules/socials/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/socials/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/socials/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/socials/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/socials/delete`


<!-- END_5aa41566d625c634b5ae7586a2d6816c -->

<!-- START_786bb2f4159920a5188226fe48408034 -->
## api/modules/socials/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/socials/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/socials/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/socials/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/socials/create`


<!-- END_786bb2f4159920a5188226fe48408034 -->

<!-- START_a346fd502ba4f50ca8c5bb3978677a0f -->
## api/modules/slider/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/slider/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/slider/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/slider/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/slider/create`


<!-- END_a346fd502ba4f50ca8c5bb3978677a0f -->

<!-- START_b82300e56b362bed0c05b64db3e1d0fe -->
## api/modules/slider/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/slider/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/slider/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/slider/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/slider/update`


<!-- END_b82300e56b362bed0c05b64db3e1d0fe -->

<!-- START_9bcd5dff14edadd62830ea5268053e49 -->
## api/modules/slider/search
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/slider/search',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/slider/search'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/slider/search"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/slider/search`


<!-- END_9bcd5dff14edadd62830ea5268053e49 -->

<!-- START_ca233632703affc277b0baf1aa0d1353 -->
## api/modules/slider/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/slider/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/slider/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/slider/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/slider/delete`


<!-- END_ca233632703affc277b0baf1aa0d1353 -->

<!-- START_3778351f2c621537fcb207fd7be3fae0 -->
## api/modules/slider/search/dynamic
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/slider/search/dynamic',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/slider/search/dynamic'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/slider/search/dynamic"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/slider/search/dynamic`


<!-- END_3778351f2c621537fcb207fd7be3fae0 -->

<!-- START_19eb0da4b4067fe3707f802e23102043 -->
## api/modules/slider/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/slider/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/slider/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/slider/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/slider/edit`


<!-- END_19eb0da4b4067fe3707f802e23102043 -->

<!-- START_e4768f95b251f8210626c2cc83b422b6 -->
## api/modules/slider/search/role
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/slider/search/role',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/slider/search/role'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/slider/search/role"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/slider/search/role`


<!-- END_e4768f95b251f8210626c2cc83b422b6 -->

<!-- START_944e8c403bda95ad15fa7373d76ab1ab -->
## api/modules/slider/validate
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/slider/validate',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/slider/validate'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/slider/validate"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/slider/validate`


<!-- END_944e8c403bda95ad15fa7373d76ab1ab -->

<!-- START_ffab03f161fafe0019e26fa1038c89c6 -->
## api/modules/slide/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/slide/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/slide/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/slide/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/slide/delete`


<!-- END_ffab03f161fafe0019e26fa1038c89c6 -->

<!-- START_459d31c4c46e0db205f0e7a9247deb4f -->
## api/modules/slide/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/slide/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/slide/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/slide/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/slide/edit`


<!-- END_459d31c4c46e0db205f0e7a9247deb4f -->

<!-- START_6fd97f2a301b09a9d530f8b780a9af5a -->
## api/modules/article/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/article/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/article/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/article/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/article/create`


<!-- END_6fd97f2a301b09a9d530f8b780a9af5a -->

<!-- START_04c67d00bf7b113f9ea22424b0e03cd3 -->
## api/modules/article/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/article/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/article/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/article/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/article/update`


<!-- END_04c67d00bf7b113f9ea22424b0e03cd3 -->

<!-- START_fd5028e4669f7692cf017f945bc31aaf -->
## api/modules/article/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/article/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/article/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/article/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/article/edit`


<!-- END_fd5028e4669f7692cf017f945bc31aaf -->

<!-- START_b7f3a44dfb377a8e3d2e4012dacf2f70 -->
## api/modules/article/validate
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/article/validate',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/article/validate'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/article/validate"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/article/validate`


<!-- END_b7f3a44dfb377a8e3d2e4012dacf2f70 -->

<!-- START_cc1d4ae6ad4e6e9e1575d8ca2e7d9d08 -->
## api/modules/article/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/article/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/article/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/article/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/article/delete`


<!-- END_cc1d4ae6ad4e6e9e1575d8ca2e7d9d08 -->

<!-- START_b1e08140a1f8ad3eefa522b3d34c2554 -->
## api/modules/article/search
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/article/search',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/article/search'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/article/search"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/article/search`


<!-- END_b1e08140a1f8ad3eefa522b3d34c2554 -->

<!-- START_4830c9fb3ef326b93c3928aed6804ea6 -->
## api/modules/comment/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/comment/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/comment/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/comment/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/comment/create`


<!-- END_4830c9fb3ef326b93c3928aed6804ea6 -->

<!-- START_c9c8798f7e7df92a6f3a368845d1fa21 -->
## api/modules/comment/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/comment/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/comment/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/comment/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/comment/update`


<!-- END_c9c8798f7e7df92a6f3a368845d1fa21 -->

<!-- START_27eaac4023966b3ffec7854ce425f590 -->
## api/modules/comment/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/comment/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/comment/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/comment/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/comment/edit`


<!-- END_27eaac4023966b3ffec7854ce425f590 -->

<!-- START_286f90db6e5ce4a160744dd4fbec3399 -->
## api/modules/comment/validate
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/comment/validate',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/comment/validate'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/comment/validate"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/comment/validate`


<!-- END_286f90db6e5ce4a160744dd4fbec3399 -->

<!-- START_54a2e78f10eeb127d3094943073283f8 -->
## api/modules/comment/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/comment/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/comment/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/comment/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/comment/delete`


<!-- END_54a2e78f10eeb127d3094943073283f8 -->

<!-- START_83aea756e75629c654933912344b8699 -->
## api/modules/section/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/section/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/section/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/section/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/section/create`


<!-- END_83aea756e75629c654933912344b8699 -->

<!-- START_6788258cd6763de12f76f065c534e82e -->
## api/modules/section/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/section/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/section/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/section/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/section/update`


<!-- END_6788258cd6763de12f76f065c534e82e -->

<!-- START_a9601602309267047f55f206b3bdb39e -->
## api/modules/section/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/section/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/section/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/section/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/section/edit`


<!-- END_a9601602309267047f55f206b3bdb39e -->

<!-- START_cd55641295c4156700a89bf7c2a225c0 -->
## api/modules/section/validate
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/section/validate',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/section/validate'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/section/validate"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/section/validate`


<!-- END_cd55641295c4156700a89bf7c2a225c0 -->

<!-- START_0691c22d85c2c69ef2207cacf8073e2d -->
## api/modules/section/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/section/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/section/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/section/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/section/delete`


<!-- END_0691c22d85c2c69ef2207cacf8073e2d -->

<!-- START_488d1e01305ad974501dbc7219b8ea1e -->
## api/modules/feedback/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/feedback/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/feedback/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/feedback/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/feedback/create`


<!-- END_488d1e01305ad974501dbc7219b8ea1e -->

<!-- START_5c9308cabf7136095ffa3069cc42a44e -->
## api/modules/feedback/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/feedback/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/feedback/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/feedback/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/feedback/update`


<!-- END_5c9308cabf7136095ffa3069cc42a44e -->

<!-- START_5dc1b48ad02511ee6bac9eaac486433b -->
## api/modules/feedback/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/feedback/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/feedback/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/feedback/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/feedback/edit`


<!-- END_5dc1b48ad02511ee6bac9eaac486433b -->

<!-- START_f167572fa126aec9bd704189f3628497 -->
## api/modules/feedback/validate
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/feedback/validate',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/feedback/validate'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/feedback/validate"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/feedback/validate`


<!-- END_f167572fa126aec9bd704189f3628497 -->

<!-- START_7c1c42df00037c3c7f6d620873b7dc91 -->
## api/modules/feedback/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/feedback/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/feedback/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/feedback/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/feedback/delete`


<!-- END_7c1c42df00037c3c7f6d620873b7dc91 -->

<!-- START_2f89aca8a512544a039ef83bcbf1c6dd -->
## api/modules/stroke/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/stroke/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/stroke/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/stroke/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/stroke/edit`


<!-- END_2f89aca8a512544a039ef83bcbf1c6dd -->

<!-- START_2c34a6e4bff9142f63bbd24522d7a9bf -->
## api/modules/stroke/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/stroke/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/stroke/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/stroke/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/stroke/create`


<!-- END_2c34a6e4bff9142f63bbd24522d7a9bf -->

<!-- START_61bcf6c84c05c2916997cb7982bbe40d -->
## api/modules/stroke/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/stroke/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/stroke/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/stroke/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/stroke/update`


<!-- END_61bcf6c84c05c2916997cb7982bbe40d -->

<!-- START_9a7f3653e24d7190b30f9dc9c5c0c43b -->
## api/modules/stroke/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/stroke/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/stroke/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/stroke/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/stroke/delete`


<!-- END_9a7f3653e24d7190b30f9dc9c5c0c43b -->

<!-- START_1249c284f0e82efcc987bb76c785e68f -->
## api/modules/stroke/sort
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/stroke/sort',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/stroke/sort'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/stroke/sort"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/stroke/sort`


<!-- END_1249c284f0e82efcc987bb76c785e68f -->

<!-- START_3425e16804724d07a11e9095c5397122 -->
## api/modules/competitive-advantages/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/competitive-advantages/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/competitive-advantages/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/competitive-advantages/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/competitive-advantages/edit`


<!-- END_3425e16804724d07a11e9095c5397122 -->

<!-- START_ebc461bf7b6d43479aeb11568d2a3c89 -->
## api/modules/competitive-advantages/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/competitive-advantages/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/competitive-advantages/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/competitive-advantages/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/competitive-advantages/create`


<!-- END_ebc461bf7b6d43479aeb11568d2a3c89 -->

<!-- START_8f8d63abd4402f848c9fb25d03b54040 -->
## api/modules/competitive-advantages/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/competitive-advantages/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/competitive-advantages/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/competitive-advantages/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/competitive-advantages/update`


<!-- END_8f8d63abd4402f848c9fb25d03b54040 -->

<!-- START_216df65da6c5c1a9c501a88d0c2810f4 -->
## api/modules/competitive-advantages/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/competitive-advantages/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/competitive-advantages/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/competitive-advantages/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/competitive-advantages/delete`


<!-- END_216df65da6c5c1a9c501a88d0c2810f4 -->

<!-- START_921512ec6de2846f81b00bc0f68b24f5 -->
## api/modules/footer-options/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/footer-options/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/footer-options/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/footer-options/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/footer-options/edit`


<!-- END_921512ec6de2846f81b00bc0f68b24f5 -->

<!-- START_f30a1a068e24d3ab96abca953e1ec86b -->
## api/modules/footer-options/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/footer-options/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/footer-options/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/footer-options/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/footer-options/create`


<!-- END_f30a1a068e24d3ab96abca953e1ec86b -->

<!-- START_11d7c2102c9d1198fb86c82515e10bed -->
## api/modules/footer-options/update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/footer-options/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/footer-options/update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/footer-options/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/footer-options/update`


<!-- END_11d7c2102c9d1198fb86c82515e10bed -->

<!-- START_59732b7bc86689ce94fb3c92755230af -->
## api/modules/footer-options/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/footer-options/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/footer-options/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/footer-options/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/footer-options/delete`


<!-- END_59732b7bc86689ce94fb3c92755230af -->

<!-- START_fe70ccde1c59a0c2078dbb10c6eb1e3b -->
## api/modules/v2/article/sort
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/v2/article/sort',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/v2/article/sort'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/v2/article/sort"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/v2/article/sort`


<!-- END_fe70ccde1c59a0c2078dbb10c6eb1e3b -->

<!-- START_d4eb7096d46526079859e6038ed7c980 -->
## api/modules/v2/feedback/send
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/v2/feedback/send',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/v2/feedback/send'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/v2/feedback/send"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/v2/feedback/send`


<!-- END_d4eb7096d46526079859e6038ed7c980 -->

<!-- START_7e063687c87547a6d5eb769b6e29ae5b -->
## api/modules/v2/section/sort
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/modules/v2/section/sort',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/v2/section/sort'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/v2/section/sort"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/modules/v2/section/sort`


<!-- END_7e063687c87547a6d5eb769b6e29ae5b -->

<!-- START_7f9a51020d9afe1c3891bca8ef954cf5 -->
## api/modules/v2/slider/validate
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/v2/slider/validate',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/v2/slider/validate'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/v2/slider/validate"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/v2/slider/validate`


<!-- END_7f9a51020d9afe1c3891bca8ef954cf5 -->

<!-- START_8f5671fa4299dccb4d5f2b6a12128a9c -->
## api/modules/v2/slide/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/v2/slide/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/v2/slide/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/v2/slide/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/v2/slide/delete`


<!-- END_8f5671fa4299dccb4d5f2b6a12128a9c -->

<!-- START_41f58aea34bafd9ca8717cad58362d34 -->
## api/modules/v2/slide/add_or_update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/v2/slide/add_or_update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/v2/slide/add_or_update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/v2/slide/add_or_update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/v2/slide/add_or_update`


<!-- END_41f58aea34bafd9ca8717cad58362d34 -->

<!-- START_bfeb5af83ec5c7c9337911ab3bb5b88d -->
## api/modules/v2/competitive-advantages/items/delete
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/v2/competitive-advantages/items/delete',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/v2/competitive-advantages/items/delete'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/v2/competitive-advantages/items/delete"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/v2/competitive-advantages/items/delete`


<!-- END_bfeb5af83ec5c7c9337911ab3bb5b88d -->

<!-- START_325fc9b96093b94db3851d089cfd4efa -->
## api/modules/v2/competitive-advantages/items/copy
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/v2/competitive-advantages/items/copy',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/v2/competitive-advantages/items/copy'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/v2/competitive-advantages/items/copy"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/v2/competitive-advantages/items/copy`


<!-- END_325fc9b96093b94db3851d089cfd4efa -->

<!-- START_05638f5d11f35e30aceb9bcc5c794c92 -->
## api/modules/v2/competitive-advantages/items/add_or_update
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/modules/v2/competitive-advantages/items/add_or_update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/modules/v2/competitive-advantages/items/add_or_update'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/modules/v2/competitive-advantages/items/add_or_update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/modules/v2/competitive-advantages/items/add_or_update`


<!-- END_05638f5d11f35e30aceb9bcc5c794c92 -->

<!-- START_5d8dc86c66634cff53b6bd6507594cc8 -->
## confirm_email_change/{hash}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/confirm_email_change/1',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/confirm_email_change/1'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/confirm_email_change/1"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET confirm_email_change/{hash}`


<!-- END_5d8dc86c66634cff53b6bd6507594cc8 -->

<!-- START_3910fde69851a494bd1a9947488d654d -->
## confirm_phone_change/{hash}
> Example request:

```bash
curl -X GET \
    -G "http://localhost/confirm_phone_change/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/confirm_phone_change/1"
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

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/confirm_phone_change/1',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET confirm_phone_change/{hash}`


<!-- END_3910fde69851a494bd1a9947488d654d -->
<!-- START_57684fcd6f8dc2a259e8acec0d22b70f -->
## sites
> Example request:

```bash
curl -X GET \
    -G "http://localhost/sites" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/sites"
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

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/sites',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET sites`


<!-- END_57684fcd6f8dc2a259e8acec0d22b70f -->
<!-- START_bd0b52517f15e37bbc0dc6959f7a4525 -->
## tags/delete/{tag_id}
> Example request:

```bash
curl -X GET \
    -G "http://localhost/tags/delete/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/tags/delete/1"
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

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/tags/delete/1',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET tags/delete/{tag_id}`


<!-- END_bd0b52517f15e37bbc0dc6959f7a4525 -->
<!-- START_a50cb6b455f1a074202427a3ab9fd022 -->
## tags/edit/{tag_id}
> Example request:

```bash
curl -X GET \
    -G "http://localhost/tags/edit/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/tags/edit/1"
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

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/tags/edit/1',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET tags/edit/{tag_id}`


<!-- END_a50cb6b455f1a074202427a3ab9fd022 -->
<!-- START_f219fe74ac4d00067f686a91a5b53a47 -->
## storage-manager/upload
> Example request:

```bash
curl -X POST \
    "http://localhost/storage-manager/upload" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/storage-manager/upload"
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

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/storage-manager/upload',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST storage-manager/upload`


<!-- END_f219fe74ac4d00067f686a91a5b53a47 -->
<!-- START_4f8a6dfb7045a7cd9c7ccf9d67a664f8 -->
## storage-manager/browse
> Example request:

```bash
curl -X GET \
    -G "http://localhost/storage-manager/browse" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/storage-manager/browse"
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

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/storage-manager/browse',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET storage-manager/browse`


<!-- END_4f8a6dfb7045a7cd9c7ccf9d67a664f8 -->
<!-- START_bfce99235a6dd8fd0a2a4195f2565ecc -->
## api/complains/article/send
> Example request:

```bash
curl -X POST \
    "http://localhost/api/complains/article/send" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/complains/article/send"
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

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/complains/article/send',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST api/complains/article/send`


<!-- END_bfce99235a6dd8fd0a2a4195f2565ecc -->
<!-- START_9129629431eae65810f5e7a91ca800d0 -->
## api/complains/comment/send
> Example request:

```bash
curl -X POST \
    "http://localhost/api/complains/comment/send" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/complains/comment/send"
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

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/complains/comment/send',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST api/complains/comment/send`


<!-- END_9129629431eae65810f5e7a91ca800d0 -->
<!-- START_5aeded2bdd762261a72b24f803a0caea -->
## moderate
> Example request:

```bash
curl -X GET \
    -G "http://localhost/moderate" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/moderate"
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

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/moderate',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET moderate`


<!-- END_5aeded2bdd762261a72b24f803a0caea -->
<!-- START_0831d7cbd24dc1fde706f7a6a61def8b -->
## moderation_answer/{id}/confirm
> Example request:

```bash
curl -X GET \
    -G "http://localhost/moderation_answer/1/confirm" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/moderation_answer/1/confirm"
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

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/moderation_answer/1/confirm',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET moderation_answer/{id}/confirm`


<!-- END_0831d7cbd24dc1fde706f7a6a61def8b -->
<!-- START_43326d0f246e780ad6965dbc8c50681b -->
## r
> Example request:

```bash
curl -X GET \
    -G "http://localhost/r" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/r"
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

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/r',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET r`


<!-- END_43326d0f246e780ad6965dbc8c50681b -->
<!-- START_0c12b2811028e88e069255bb8a4fc06b -->
## api/user/permissions
> Example request:

```bash
curl -X POST \
    "http://localhost/api/user/permissions" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/user/permissions"
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

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/user/permissions',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST api/user/permissions`


<!-- END_0c12b2811028e88e069255bb8a4fc06b -->
<!-- START_cf4e254c1eaf508cce4668c34d271a8e -->
## api/tags/search
> Example request:

```bash
curl -X POST \
    "http://localhost/api/tags/search" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/tags/search"
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

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/tags/search',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST api/tags/search`


<!-- END_cf4e254c1eaf508cce4668c34d271a8e -->
<!-- START_acc54990205aee64bbd2876404ba60f8 -->
## api/search/city
> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/search/city" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/search/city"
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

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/search/city',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/search/city`


<!-- END_acc54990205aee64bbd2876404ba60f8 -->
<!-- START_eec4cf9af0129aeab28e5606f4f2f837 -->
## api/search/country
> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/search/country" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/search/country"
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

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/search/country',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/search/country`


<!-- END_eec4cf9af0129aeab28e5606f4f2f837 -->
<!-- START_00e7e21641f05de650dbe13f242c6f2c -->
## api/logout
> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/logout" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/logout"
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

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/logout',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/logout`


<!-- END_00e7e21641f05de650dbe13f242c6f2c -->
<!-- START_6d3061d375666b8cf6babe163b36f250 -->
## api/reset-password
> Example request:

```bash
curl -X POST \
    "http://localhost/api/reset-password" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/reset-password"
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

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/reset-password',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST api/reset-password`


<!-- END_6d3061d375666b8cf6babe163b36f250 -->
<!-- START_960355c92aa59a3128ecc7a6fc57acb5 -->
## api/forgot/send-code
> Example request:

```bash
curl -X POST \
    "http://localhost/api/forgot/send-code" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/forgot/send-code"
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

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/forgot/send-code',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST api/forgot/send-code`


<!-- END_960355c92aa59a3128ecc7a6fc57acb5 -->
<!-- START_f5b42835376b087d16f21826171eba07 -->
## api/forgot/change-password
> Example request:

```bash
curl -X POST \
    "http://localhost/api/forgot/change-password" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/forgot/change-password"
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

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/forgot/change-password',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST api/forgot/change-password`


<!-- END_f5b42835376b087d16f21826171eba07 -->
<!-- START_ca4e26b575be91bbfb3d8a775b7e18dc -->
## api/forgot/check-code
> Example request:

```bash
curl -X POST \
    "http://localhost/api/forgot/check-code" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/forgot/check-code"
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

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/forgot/check-code',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST api/forgot/check-code`


<!-- END_ca4e26b575be91bbfb3d8a775b7e18dc -->
<!-- START_1c58cec292d5bd4f8c78f66a114c38dd -->
## api/forgot/check-login
> Example request:

```bash
curl -X POST \
    "http://localhost/api/forgot/check-login" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/forgot/check-login"
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

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/forgot/check-login',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST api/forgot/check-login`


<!-- END_1c58cec292d5bd4f8c78f66a114c38dd -->
<!-- START_4496165454764caf2d2badca3304b79f -->
## api/register/check-login
> Example request:

```bash
curl -X POST \
    "http://localhost/api/register/check-login" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/register/check-login"
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

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/register/check-login',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST api/register/check-login`


<!-- END_4496165454764caf2d2badca3304b79f -->
<!-- START_92ac8a4414cc5175b84629b866475672 -->
## api/register/check-email
> Example request:

```bash
curl -X POST \
    "http://localhost/api/register/check-email" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/register/check-email"
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

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/register/check-email',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST api/register/check-email`


<!-- END_92ac8a4414cc5175b84629b866475672 -->
<!-- START_9d1ca5a64c0ede0a532d34b3140ba2c5 -->
## api/register/check-phone
> Example request:

```bash
curl -X POST \
    "http://localhost/api/register/check-phone" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/register/check-phone"
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

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/register/check-phone',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST api/register/check-phone`


<!-- END_9d1ca5a64c0ede0a532d34b3140ba2c5 -->
<!-- START_a4fa7baa8d6d9182aba2368276bf7433 -->
## api/register/send-code
> Example request:

```bash
curl -X POST \
    "http://localhost/api/register/send-code" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/register/send-code"
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

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/register/send-code',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST api/register/send-code`


<!-- END_a4fa7baa8d6d9182aba2368276bf7433 -->
<!-- START_b3cae5044447ca419b1405c2161315e8 -->
## api/register/check-code
> Example request:

```bash
curl -X POST \
    "http://localhost/api/register/check-code" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/register/check-code"
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

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/register/check-code',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST api/register/check-code`


<!-- END_b3cae5044447ca419b1405c2161315e8 -->
<!-- START_5cf86b32321b0964926a5155a9114f22 -->
## settings/site
> Example request:

```bash
curl -X GET \
    -G "http://localhost/settings/site" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/settings/site"
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

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/settings/site',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET settings/site`


<!-- END_5cf86b32321b0964926a5155a9114f22 -->
<!-- START_8b094272097a3c82552bd0a9ab97e1b0 -->
## settings/site/update
> Example request:

```bash
curl -X POST \
    "http://localhost/settings/site/update" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/settings/site/update"
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

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/settings/site/update',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST settings/site/update`


<!-- END_8b094272097a3c82552bd0a9ab97e1b0 -->
#Сайты


<!-- START_a63c32eb2b5dda4eee5d12fc9016391c -->
## rss
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/rss',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/rss'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/rss"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET rss`


<!-- END_a63c32eb2b5dda4eee5d12fc9016391c -->

<!-- START_569cbb17838c7c6f5e756951b9885cda -->
## Обновление сайта

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/sites/update',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
        'json' => [
            'token' => 'mollitia',
            'parent_id' => 'dicta',
            'title' => 'et',
            'content' => 'dolor',
            'domain_name' => 'quaerat',
            'domain_id' => 'consequuntur',
            'slogan' => 'maiores',
            'copyright' => 'aspernatur',
            'articles_description' => 'impedit',
            'template_id' => 15,
            'template_scheme_id' => 20,
            'default_color' => 'nostrum',
            'facebook_url' => 'ab',
            'vk_url' => 'eum',
            'ok_url' => 'et',
            'twitter_url' => 'et',
            'instagram_url' => 'ipsam',
            'address' => 'molestiae',
            'work_hours' => 'cumque',
            'email' => 'non',
            'filter_articles' => 'est',
            'filter_sections' => 'omnis',
            'articles_limit' => 4,
            'sections_limit' => 7,
            'filter_articles_sort' => 'non',
            'filter_articles_sort_direction' => 'consequatur',
            'filter_sections_sort' => 'blanditiis',
            'filter_sections_sort_direction' => 'dolorem',
            'logo' => 'porro',
            'image' => 'dolores',
            'favicon' => 'aut',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sites/update'
payload = {
    "token": "mollitia",
    "parent_id": "dicta",
    "title": "et",
    "content": "dolor",
    "domain_name": "quaerat",
    "domain_id": "consequuntur",
    "slogan": "maiores",
    "copyright": "aspernatur",
    "articles_description": "impedit",
    "template_id": 15,
    "template_scheme_id": 20,
    "default_color": "nostrum",
    "facebook_url": "ab",
    "vk_url": "eum",
    "ok_url": "et",
    "twitter_url": "et",
    "instagram_url": "ipsam",
    "address": "molestiae",
    "work_hours": "cumque",
    "email": "non",
    "filter_articles": "est",
    "filter_sections": "omnis",
    "articles_limit": 4,
    "sections_limit": 7,
    "filter_articles_sort": "non",
    "filter_articles_sort_direction": "consequatur",
    "filter_sections_sort": "blanditiis",
    "filter_sections_sort_direction": "dolorem",
    "logo": "porro",
    "image": "dolores",
    "favicon": "aut"
}
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sites/update"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

let body = {
    "token": "mollitia",
    "parent_id": "dicta",
    "title": "et",
    "content": "dolor",
    "domain_name": "quaerat",
    "domain_id": "consequuntur",
    "slogan": "maiores",
    "copyright": "aspernatur",
    "articles_description": "impedit",
    "template_id": 15,
    "template_scheme_id": 20,
    "default_color": "nostrum",
    "facebook_url": "ab",
    "vk_url": "eum",
    "ok_url": "et",
    "twitter_url": "et",
    "instagram_url": "ipsam",
    "address": "molestiae",
    "work_hours": "cumque",
    "email": "non",
    "filter_articles": "est",
    "filter_sections": "omnis",
    "articles_limit": 4,
    "sections_limit": 7,
    "filter_articles_sort": "non",
    "filter_articles_sort_direction": "consequatur",
    "filter_sections_sort": "blanditiis",
    "filter_sections_sort_direction": "dolorem",
    "logo": "porro",
    "image": "dolores",
    "favicon": "aut"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/sites/update`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `token` | string |  optional  | Токен ключ пользователя
        `parent_id` | string |  optional  | Родительский сайт
        `title` | string |  optional  | Название сайта
        `content` | Text |  optional  | Описание сайта
        `domain_name` | string |  optional  | Имя домена
        `domain_id` | string |  optional  | Поддомен для имени домена
        `slogan` | string |  optional  | Слоган
        `copyright` | string |  optional  | Копирайты снизу
        `articles_description` | Text |  optional  | Описание для страницы статей
        `template_id` | integer |  optional  | ID шаблона
        `template_scheme_id` | integer |  optional  | ID шаблона
        `default_color` | Hex |  optional  | дефолтный цвет для разделов и пр.
        `facebook_url` | Url |  optional  | Страничка на facebook
        `vk_url` | Url |  optional  | Страничка Вконтакте
        `ok_url` | Url |  optional  | Страничка Одноклассники.ру
        `twitter_url` | Url |  optional  | Страничка в twitter
        `instagram_url` | Url |  optional  | Страничка в Instagram
        `address` | string |  optional  | Адрес
        `work_hours` | string |  optional  | Время работы
        `email` | string |  optional  | Email для связи
        `filter_articles` | Boolean |  optional  | Выводить фильтр статей
        `filter_sections` | Boolean |  optional  | Выводить фильтр разделов
        `articles_limit` | integer |  optional  | Лимит статей на страницу
        `sections_limit` | integer |  optional  | Лимит разделов на страницу
        `filter_articles_sort` | string |  optional  | Сортировка статей по полю
        `filter_articles_sort_direction` | string |  optional  | Сортировка статей по возрастанию или убыванию (asc|desc)
        `filter_sections_sort` | string |  optional  | Сортировка разделов по полю
        `filter_sections_sort_direction` | string |  optional  | Сортировка разделов по возрастанию или убыванию (asc|desc)
        `logo` | Base64 |  optional  | Лого для сайта в формате base64
        `image` | Base64 |  optional  | Фоновая картинка в формате base64
        `favicon` | Base64 |  optional  | favicon base64
    
<!-- END_569cbb17838c7c6f5e756951b9885cda -->

<!-- START_d117e1b9127b9772017656b5ad3ac2ee -->
## api/sites/destroy
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/sites/destroy',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sites/destroy'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sites/destroy"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/sites/destroy`


<!-- END_d117e1b9127b9772017656b5ad3ac2ee -->

<!-- START_e9cd677870012d2bd0882e2e6b46b6fb -->
## api/sites/update_settings
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/sites/update_settings',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sites/update_settings'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sites/update_settings"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/sites/update_settings`


<!-- END_e9cd677870012d2bd0882e2e6b46b6fb -->

<!-- START_6ca351ce6abf8fd96ed03b77af799bdf -->
## api/sites/form
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/sites/form',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sites/form'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sites/form"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/sites/form`


<!-- END_6ca351ce6abf8fd96ed03b77af799bdf -->

<!-- START_ee2a01af0e4cf26c6173987c43aefb53 -->
## api/sites/search
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/sites/search',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sites/search'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sites/search"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/sites/search`


<!-- END_ee2a01af0e4cf26c6173987c43aefb53 -->

<!-- START_1b37dde0d081b2d2ab0f79894a43b4ed -->
## api/sites/validate_domain
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/sites/validate_domain',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sites/validate_domain'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sites/validate_domain"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/sites/validate_domain`


<!-- END_1b37dde0d081b2d2ab0f79894a43b4ed -->

<!-- START_61ddaab1845cc1172d00fdb76de062d7 -->
## api/sites/validate_site
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/sites/validate_site',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sites/validate_site'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sites/validate_site"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/sites/validate_site`


<!-- END_61ddaab1845cc1172d00fdb76de062d7 -->

<!-- START_7c53a3c6d732da6c1214d4f19b28a7b8 -->
## api/sites/edit
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/sites/edit',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sites/edit'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sites/edit"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/sites/edit`


<!-- END_7c53a3c6d732da6c1214d4f19b28a7b8 -->

<!-- START_a4091cc5d50e20366ffe560cc0b56d0c -->
## api/sites/create
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/sites/create',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sites/create'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sites/create"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/sites/create`


<!-- END_a4091cc5d50e20366ffe560cc0b56d0c -->

<!-- START_0ddc0f48b2670c6963a82fe59264ecd5 -->
## api/sites/create_domain
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/sites/create_domain',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sites/create_domain'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sites/create_domain"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/sites/create_domain`


<!-- END_0ddc0f48b2670c6963a82fe59264ecd5 -->

<!-- START_c7f8ff2a88aa9649a69524dacbd0d48f -->
## api/sites/update_domain
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/sites/update_domain',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sites/update_domain'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sites/update_domain"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/sites/update_domain`


<!-- END_c7f8ff2a88aa9649a69524dacbd0d48f -->

<!-- START_4aff7f8fdba6c8dc5a68da05ebff9161 -->
## api/sites/filter_domains
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/sites/filter_domains',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sites/filter_domains'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sites/filter_domains"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/sites/filter_domains`


<!-- END_4aff7f8fdba6c8dc5a68da05ebff9161 -->

<!-- START_4ab5c3810548c67c0b7a651d63e4d750 -->
## api/sites/options/save
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/sites/options/save',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sites/options/save'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sites/options/save"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/sites/options/save`


<!-- END_4ab5c3810548c67c0b7a651d63e4d750 -->

<!-- START_6df0ceafb585970a208e009524f81f06 -->
## api/sites/options/form
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/sites/options/form',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sites/options/form'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sites/options/form"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/sites/options/form`


<!-- END_6df0ceafb585970a208e009524f81f06 -->

<!-- START_1196f01362198ef793201f191afe51b0 -->
## api/sites/view/save
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/sites/view/save',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sites/view/save'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sites/view/save"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/sites/view/save`


<!-- END_1196f01362198ef793201f191afe51b0 -->

<!-- START_63300cf94a0703b922a46da249cc54ce -->
## api/sites/view/form
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/sites/view/form',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sites/view/form'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sites/view/form"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/sites/view/form`


<!-- END_63300cf94a0703b922a46da249cc54ce -->

<!-- START_61f46d238be446f70d72c9529cf34105 -->
## api/sites/seo/save
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/sites/seo/save',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sites/seo/save'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sites/seo/save"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/sites/seo/save`


<!-- END_61f46d238be446f70d72c9529cf34105 -->

<!-- START_6fffda26b932bcf3bcee832b6c93ec7f -->
## api/sites/seo/form
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/sites/seo/form',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sites/seo/form'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sites/seo/form"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/sites/seo/form`


<!-- END_6fffda26b932bcf3bcee832b6c93ec7f -->

<!-- START_a854f0c046d5f36ae1abb836f5e156b8 -->
## api/sites/contacts/form
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/sites/contacts/form',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sites/contacts/form'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sites/contacts/form"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/sites/contacts/form`


<!-- END_a854f0c046d5f36ae1abb836f5e156b8 -->

<!-- START_7ffafd8e4521d02d30eab72407aedbfb -->
## api/sites/contacts/save
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://domain.ltd/api/sites/contacts/save',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sites/contacts/save'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('POST', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sites/contacts/save"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/sites/contacts/save`


<!-- END_7ffafd8e4521d02d30eab72407aedbfb -->

<!-- START_299218a579f088805bbc259cc63b5011 -->
## api/sites/home
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/sites/home',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sites/home'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sites/home"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/sites/home`


<!-- END_299218a579f088805bbc259cc63b5011 -->

<!-- START_5bf5bb6675bbc3130737a45bec5829c0 -->
## api/sites/settings
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/sites/settings',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sites/settings'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sites/settings"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/sites/settings`


<!-- END_5bf5bb6675bbc3130737a45bec5829c0 -->

<!-- START_fee65dad1926c358cdd610164555e5df -->
## api/sites/slug
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/sites/slug',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sites/slug'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sites/slug"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/sites/slug`


<!-- END_fee65dad1926c358cdd610164555e5df -->

<!-- START_03459e35d7ae0a6420523fddde971ab0 -->
## api/sites/tree
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/sites/tree',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sites/tree'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sites/tree"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/sites/tree`


<!-- END_03459e35d7ae0a6420523fddde971ab0 -->

<!-- START_da6bc93e5dc3bb7469b65117da6a2f3f -->
## api/sites/search_domain
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/sites/search_domain',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sites/search_domain'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sites/search_domain"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/sites/search_domain`


<!-- END_da6bc93e5dc3bb7469b65117da6a2f3f -->

<!-- START_494e8ee5249a926fc4d4f946ab465d61 -->
## api/sites/check
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/sites/check',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sites/check'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sites/check"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/sites/check`


<!-- END_494e8ee5249a926fc4d4f946ab465d61 -->

<!-- START_69e0cf68b48109c10f83e47cfd98dc34 -->
## api/sites/theme
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://domain.ltd/api/sites/theme',
    [
        'headers' => [
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/form-data',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://domain.ltd/api/sites/theme'
headers = {
  'Content-Type': 'application/form-data',
  'Accept': 'application/form-data'
}
response = requests.request('GET', url, headers=headers)
response.json()
```

```javascript
const url = new URL(
    "https://domain.ltd/api/sites/theme"
);

let headers = {
    "Content-Type": "application/form-data",
    "Accept": "application/form-data",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET api/sites/theme`


<!-- END_69e0cf68b48109c10f83e47cfd98dc34 -->


