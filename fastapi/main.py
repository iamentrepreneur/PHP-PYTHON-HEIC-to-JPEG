from fastapi import FastAPI, UploadFile, File, HTTPException
from fastapi.responses import Response
import pyheif
from PIL import Image
import io

app = FastAPI()

@app.post("/convert")
async def convert_heic(file: UploadFile = File(...)):
    try:
        contents = await file.read()
        heif_file = pyheif.read(contents)
        image = Image.frombytes(
            heif_file.mode,
            heif_file.size,
            heif_file.data,
            "raw",
            heif_file.mode,
            heif_file.stride,
        )
        output_buffer = io.BytesIO()
        image.save(output_buffer, format="JPEG", quality=95)
        output_buffer.seek(0)
        return Response(content=output_buffer.read(), media_type="image/jpeg")
    except Exception as e:
        raise HTTPException(status_code=500, detail=str(e))
