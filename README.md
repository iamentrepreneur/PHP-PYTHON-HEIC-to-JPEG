# PHP-PYTHON-HEIC-to-JPEG


```bash

cd fastapi
```

## Устанавливаем виртуальное окружение для Python
```bash

python3 -m venv venv
source venv/bin/activate
```

## Устанавливаем FastAPI и зависимости:
```bash

pip install fastapi uvicorn pyheif pillow python-multipart
```


## Запускаем наш FastAPI сервер

```bash

uvicorn main:app --host 127.0.0.1 --port 8000
```

## пПроверка сервера

```bash

curl http://127.0.0.1:8000/docs
```