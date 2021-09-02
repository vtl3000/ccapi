# Service to get cryptocurrency pair prices
Get the current price of any cryptocurrency in any other currency that you need

## Install and run service

####1. Clone repository:
```bash
git clone git@github.com:vtl3000/ccapi.git
```

####2. Run service:
```
docker-compose up -d --build
```

####3. Modify .env file (optional)

Get api key from integration service [Cryptocompare](https://www.cryptocompare.com/cryptopian/api-keys)
Change .env `CRYPTOCOMPARE_API_KEY` parameter to yous:
```dotenv
CRYPTOCOMPARE_API_KEY=<YOUR_CRYPTOCOMPARE_API_KEY>
```

---

####To stop service run
```
docker-compose down
```

---
###API
####Request:
params:

source=BTC

targets=JPY,USD,EUR

date_from=2021-09-02

date_to=2021-09-03
```
GET /cryptocurrency/price?source=BTC&targets=JPY&date_from=2021-09-02&date_to=2021-09-10 
```

####Response:
Content-Type: application/json

HTTP/1.1 200 OK

success:
```json
{
  "source": "BTC",
  "targets": [
    "JPY"
  ],
  "date_from": "2021-09-02",
  "date_to": "2021-09-10",
  "limit": 1000,
  "offset": 0,
  "pairs": {
    "BTC_JPY": [
      {
        "pair": "BTC_JPY",
        "value": 5447467.99,
        "time": "2021-09-02T06:55:05Z"
      },
      {
        "pair": "BTC_JPY",
        "value": 5453996.89,
        "time": "2021-09-02T06:56:03Z"
      }
    ]
  }
}
```

error:

HTTP/1.1 400 Bad Request
```json
[
  {
    "[source]": "This value should not be blank."
  },
  {
    "[targets]": "This value should not be blank."
  },
  {
    "[date_from]": "This value should not be blank."
  },
  {
    "[date_to]": "This value should not be blank."
  }
]
```