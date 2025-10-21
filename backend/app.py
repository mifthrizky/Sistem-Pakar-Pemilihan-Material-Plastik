from flask import Flask, request, jsonify

app = Flask(__name__)

# Knowledge Base berdasarkan tabel informasi
knowledge_base = {
    "polypropylene (pp)": {
        "rekomendasi": "Polypropylene (PP)",
        "alasan": "Pilihan paling ekonomis dengan ketahanan panas superior (dibanding PE). Membantu menjaga tema material yang kohesif di seluruh interior kendaraan melalui penggunaan material dasar yang sama pada berbagai komponen seperti pillar covers, door panels, dan IP-A. Karena komponen IP-A selalu bersentuhan satu sama lain, penggunaan PP memungkinkan mereka menahan siklus suhu dengan baik.",
        "karakteristik": ["Ketahanan panas tinggi", "Biaya rendah", "Kohesivitas material", "Tahan siklus suhu"]
    },
    "thermoplastic olefin (tpo)": {
        "rekomendasi": "Thermoplastic Olefin (TPE-O or TPO)",
        "alasan": "Menghasilkan tampilan akhir low-gloss dengan densitas rendah. Memiliki kekakuan (stiffness) dan ketangguhan (toughness) yang tinggi, serta dapat didaur ulang. Sangat mudah diproses dengan injection molding dan semakin banyak digunakan sebagai skin PP foam di kendaraan terbaru.",
        "karakteristik": ["Low-gloss", "Densitas rendah", "Kekakuan tinggi", "Recyclable", "Mudah diproses"]
    },
    "acrylonitrile butadiene styrene (abs)": {
        "rekomendasi": "Acrylonitrile Butadiene Styrene (ABS)",
        "alasan": "Material sangat serbaguna dengan tingkat fleksibilitas tinggi karena rasio A, B, dan S dapat divariasikan, memungkinkan penggunaannya di pillars, IP, dan door panels. Memiliki kekuatan impak dan ketangguhan sangat baik berkat kandungan karet dari polybutadiene. Ketahanan tinggi terhadap chemical stress cracking karena acrylonitrile, dan mudah diproses.",
        "karakteristik": ["Kekuatan impak tinggi", "Versatile/serbaguna", "Tahan retak kimia", "Mudah diproses"]
    },
    "abs/pc blend": {
        "rekomendasi": "ABS/PC Blend",
        "alasan": "Solusi premium yang menawarkan temperatur defleksi panas (heat deflection) sangat tinggi dan kemampuan untuk menghasilkan berbagai macam tipe permukaan yang berbeda. Tersedia dalam empat grade berbeda: general purpose, high flow, blow molding, dan low gloss. Saat ini digunakan di Jeep Cherokee dan Audi A4 (B5) models.",
        "karakteristik": ["Heat deflection tinggi", "Beragam tipe permukaan", "Mudah diproses", "Multiple grades"]
    },
    "polyvinyl chloride (pvc)": {
        "rekomendasi": "Polyvinyl Chloride (PVC)",
        "alasan": "Unggul dalam aspek keamanan dengan rasio harga terhadap properti yang sangat baik dan flame retardancy tinggi. Dapat di-blend dengan ABS untuk membentuk sheet yang digunakan untuk membuat skin dari IP covers, meskipun TPO dapat menjadi alternatif yang sama baiknya.",
        "karakteristik": ["Flame retardancy tinggi", "Price/property ratio baik", "Dapat di-blend", "Keamanan tinggi"]
    },
    "styrene-maleic anhydride (sma)": {
        "rekomendasi": "Styrene-Maleic Anhydride Copolymers (SMA)",
        "alasan": "Memiliki ketahanan panas excellent dibandingkan polystyrene pada umumnya. Dapat diperkuat dengan glass fiber untuk meningkatkan ketahanan panas lebih lanjut, dan dengan rubber untuk mencegah plastik menjadi terlalu brittle. Digunakan di IP BMW 3 dan 5 series serta di Fiat Coupé, dikombinasikan dengan polyurethane foam.",
        "karakteristik": ["Ketahanan panas excellent", "Dapat diperkuat glass fiber", "Dapat diperkuat rubber", "Premium application"]
    },
    "polyurethanes": {
        "rekomendasi": "Polyurethanes",
        "alasan": "Pilihan terbaik untuk keselamatan penumpang. Polyether polyols telah digunakan untuk membentuk instrument dan door panels via reaction injection molding (RIM). Energy-absorbing polyurethane foam dengan struktur sel semiclosed telah ditambahkan ke pillars dan door panels, memberikan perlindungan lebih baik untuk penumpang dalam kasus side impact. Memiliki kekuatan impak sangat tinggi terutama pada suhu rendah dan temperature stiffness yang tinggi, mencegah heat sag.",
        "karakteristik": ["Kekuatan impak tinggi (suhu rendah)", "Energy-absorbing", "Temperature stiffness tinggi", "Keselamatan optimal"]
    }
}

@app.route('/api/rekomendasi', methods=['POST'])
def get_rekomendasi():
    fakta = request.get_json()
    
    if not fakta:
        return jsonify({"error": "Input tidak valid!"}), 400
    
    # Sistem Scoring untuk menentukan material terbaik
    # Setiap material mendapat skor berdasarkan kecocokan dengan kebutuhan
    scores = {
        "polypropylene (pp)": 0,
        "thermoplastic olefin (tpo)": 0,
        "acrylonitrile butadiene styrene (abs)": 0,
        "abs/pc blend": 0,
        "polyvinyl chloride (pvc)": 0,
        "styrene-maleic anhydride (sma)": 0,
        "polyurethanes": 0
    }
    
    # === SISTEM SCORING BERBASIS PRIORITAS ===
    
    # 1. BIAYA (Weight: 3)
    if fakta.get('biaya') == 'ya':
        scores["polypropylene (pp)"] += 3
        scores["polyvinyl chloride (pvc)"] += 2
        scores["thermoplastic olefin (tpo)"] += 2
    
    # 2. KETAHANAN PANAS (Weight: 3-4)
    if fakta.get('panas') == 'sangat_penting':
        scores["styrene-maleic anhydride (sma)"] += 4
        scores["abs/pc blend"] += 3
        scores["polypropylene (pp)"] += 3
    elif fakta.get('panas') == 'cukup_penting':
        scores["polypropylene (pp)"] += 2
        scores["abs/pc blend"] += 2
    
    # 3. KEKUATAN IMPAK (Weight: 3-4)
    if fakta.get('impak') == 'ya':
        if fakta.get('suhu_rendah') == 'ya':
            scores["polyurethanes"] += 4  # Spesialis impak suhu rendah
            scores["acrylonitrile butadiene styrene (abs)"] += 2
        else:
            scores["acrylonitrile butadiene styrene (abs)"] += 3
            scores["polyurethanes"] += 2
    
    # 4. ESTETIKA PERMUKAAN (Weight: 2-3)
    if fakta.get('estetika') == 'low_gloss':
        scores["thermoplastic olefin (tpo)"] += 3
        scores["abs/pc blend"] += 1  # Ada grade low-gloss
    elif fakta.get('estetika') == 'beragam':
        scores["abs/pc blend"] += 3
        scores["acrylonitrile butadiene styrene (abs)"] += 2
    elif fakta.get('estetika') == 'seragam':
        scores["polypropylene (pp)"] += 3
    
    # 5. FLAME RETARDANCY (Weight: 4 - Keamanan tinggi)
    if fakta.get('api') == 'ya':
        scores["polyvinyl chloride (pvc)"] += 4
        scores["polyurethanes"] += 1
    
    # 6. KEMUDAHAN PROSES (Weight: 2)
    if fakta.get('proses') == 'ya':
        scores["thermoplastic olefin (tpo)"] += 2
        scores["abs/pc blend"] += 2
        scores["acrylonitrile butadiene styrene (abs)"] += 2
    
    # 7. RECYCLABILITY (Weight: 2)
    if fakta.get('lingkungan') == 'ya':
        scores["thermoplastic olefin (tpo)"] += 2
        scores["polypropylene (pp)"] += 1
    
    # 8. ENERGY ABSORBING (Weight: 4 - Keselamatan)
    if fakta.get('energi') == 'ya':
        scores["polyurethanes"] += 4
    
    # 9. KEKAKUAN/STIFFNESS (Weight: 2)
    if fakta.get('kekakuan') == 'ya':
        scores["thermoplastic olefin (tpo)"] += 2
        scores["polyurethanes"] += 2  # Temperature stiffness
    
    # 10. KETAHANAN KIMIA (Weight: 2)
    if fakta.get('kimia') == 'ya':
        scores["acrylonitrile butadiene styrene (abs)"] += 3
    
    # 11. GLASS FIBER REINFORCEMENT (Weight: 2)
    if fakta.get('serat') == 'ya':
        scores["styrene-maleic anhydride (sma)"] += 3
    
    # 12. VERSATILITAS/SERBAGUNA (Weight: 2)
    if fakta.get('versatile') == 'ya':
        scores["acrylonitrile butadiene styrene (abs)"] += 3
        scores["abs/pc blend"] += 2
    
    # 13. BLENDING CAPABILITY (Weight: 1)
    if fakta.get('blending') == 'ya':
        scores["polyvinyl chloride (pvc)"] += 2
        scores["abs/pc blend"] += 1
    
    # Cari material dengan skor tertinggi
    rekomendasi_key = max(scores, key=scores.get)
    max_score = scores[rekomendasi_key]
    
    # Jika tidak ada material yang menonjol (skor terlalu rendah)
    if max_score < 3:
        hasil = {
            "rekomendasi": "Kombinasi Tidak Spesifik",
            "alasan": "Berdasarkan kriteria yang Anda berikan, tidak ada satu material yang sangat menonjol. Kami sarankan untuk memprioritaskan 2-3 fitur yang paling penting untuk mendapatkan rekomendasi yang lebih spesifik.",
            "karakteristik": [],
            "skor_detail": scores,
            "alternatif": [k for k, v in sorted(scores.items(), key=lambda x: x[1], reverse=True)[:3]]
        }
    else:
        hasil = knowledge_base.get(rekomendasi_key)
        hasil["skor_detail"] = scores
        hasil["confidence"] = f"{(max_score / sum(scores.values()) * 100):.1f}%" if sum(scores.values()) > 0 else "0%"
        
        # Alternatif (2 material dengan skor tertinggi berikutnya)
        sorted_materials = sorted(scores.items(), key=lambda x: x[1], reverse=True)
        alternatif = [mat for mat, score in sorted_materials[1:3] if score >= 2]
        
        if alternatif:
            hasil["alternatif"] = {
                "material": alternatif,
                "keterangan": "Material alternatif yang juga sesuai dengan beberapa kriteria Anda"
            }
    
    return jsonify(hasil)

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)