# Gunakan image Python resmi
FROM python:3.9-slim

# Set direktori kerja di dalam container
WORKDIR /app

# Salin file requirements dan install library
COPY requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt

# Salin semua file dari folder backend ke dalam container
COPY . .

# Perintah untuk menjalankan aplikasi Flask saat container dimulai
CMD ["python", "app.py"]