import { useCallback, useState } from "react";

export default function DataUmumPerusahaan() {
  const [formData, setFormData] = useState({
    nama_penanggung_jawab: "",
    nohp_penanggung_jawab: "",
    jabatan_penanggung_jawab: "",
    email_penanggung_jawab: "",
    nama_perusahaan: "",
    tanggal_berdiri: "",
    bidang_usaha: "",
    deskripsi_perusahaan: "",
    alamat_perusahaan: "",
    provinsi: "",
    kota: "",
    kecamatan: "",
    kode_pos: "",
    email_perusahaan: "",
    telepon_perusahaan: "",
    website_perusahaan: "",
  });

  const [provinces, setProvinces] = useState([
    { id: 1, name: "Jawa Barat" },
    { id: 2, name: "Jawa Timur" },
    { id: 3, name: "Bali" },
  ]);
  const [cities, setCities] = useState([
    { id: 1, name: "Bandung" },
    { id: 2, name: "Surabaya" },
    { id: 3, name: "Denpasar" },
  ]);
  const [districts, setDistricts] = useState([
    { id: 1, name: "Cibeureum" },
    { id: 2, name: "Mulyorejo" },
    { id: 3, name: "Densel" },
  ]);

  const handleChange = useCallback((e) => {
    const { name, value } = e.target;
    setFormData((prev) => ({ ...prev, [name]: value }));
  }, []);

  const handleProvinceChange = (e) => {
    const selectedProvince = provinces.find((p) => p.name === e.target.value);
    if (!selectedProvince) return;

    setFormData((prev) => ({
      ...prev,
      provinsi: selectedProvince.name,
      kota: "",
      kecamatan: "",
    }));
  };

  const handleCityChange = (e) => {
    const selectedCity = cities.find((c) => c.name === e.target.value);
    if (!selectedCity) return;

    setFormData((prev) => ({
      ...prev,
      kota: selectedCity.name,
      kecamatan: "",
    }));
  };

  const handleDistrictChange = (e) => {
    const selectedDistrict = districts.find((d) => d.name === e.target.value);
    if (!selectedDistrict) return;

    setFormData((prev) => ({
      ...prev,
      kecamatan: selectedDistrict.name,
    }));
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    console.log("Form Data:", formData);
  };

  return (
    <div className="bg-white rounded-lg shadow p-6 max-w-8xl mx-auto">
      <form onSubmit={handleSubmit}>
        <h2 className="text-lg font-bold mb-4">Data Umum Perusahaan</h2>

        <div className="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
          {[{ label: "Nama Penanggung Jawab", name: "nama_penanggung_jawab" },
            { label: "Nomor HP Penanggung Jawab", name: "nohp_penanggung_jawab" },
            { label: "Jabatan Penanggung Jawab", name: "jabatan_penanggung_jawab" },
            { label: "Email Penanggung Jawab", name: "email_penanggung_jawab" }]
            .map((field) => (
              <div key={field.name} className="w-full">
                <label className="block text-sm font-medium text-black mb-1">{field.label}</label>
                <input
                  type="text"
                  name={field.name}
                  value={formData[field.name]}
                  onChange={handleChange}
                  placeholder={field.label}
                  className="w-full p-2 border border-[#D5DBE7] rounded placeholder-[#667797] focus:outline-none focus:ring-1 focus:ring-blue-500"
                />
              </div>
            ))}
        </div>

        <div className="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
          {[{ label: "Nama Perusahaan", name: "nama_perusahaan" },
            { label: "Tanggal Berdiri", name: "tanggal_berdiri" }]
            .map((field) => (
              <div key={field.name} className="w-full">
                <label className="block text-sm font-medium text-black mb-1">{field.label}</label>
                <input
                  type="text"
                  name={field.name}
                  value={formData[field.name]}
                  onChange={handleChange}
                  placeholder={field.label}
                  className="w-full p-2 border border-[#D5DBE7] rounded placeholder-[#667797] focus:outline-none focus:ring-1 focus:ring-blue-500"
                />
              </div>
            ))}
        </div>

        <div className="mb-6">
          <label className="block text-sm font-medium text-black mb-1">Deskripsi Perusahaan</label>
          <textarea
            name="deskripsi_perusahaan"
            value={formData.deskripsi_perusahaan}
            onChange={handleChange}
            placeholder="Tuliskan deskripsi perusahaan"
            rows={4}
            className="w-full p-2 border border-[#D5DBE7] rounded placeholder-[#667797] focus:outline-none focus:ring-1 focus:ring-blue-500 resize-none"
          />
        </div>

        <h2 className="text-lg font-bold mb-4">Kontak Perusahaan</h2>

        <div className="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
          <div>
            <label className="block text-sm font-medium text-black mb-1">Provinsi</label>
            <select
              name="provinsi"
              value={formData.provinsi}
              onChange={handleProvinceChange}
              className="w-full p-2 border border-[#D5DBE7] rounded focus:outline-none focus:ring-1 focus:ring-blue-500"
            >
              <option value="">Pilih Provinsi</option>
              {provinces.map((option) => (
                <option key={option.id} value={option.name}>{option.name}</option>
              ))}
            </select>
          </div>

          <div>
            <label className="block text-sm font-medium text-black mb-1">Kabupaten/Kota</label>
            <select
              name="kota"
              value={formData.kota}
              onChange={handleCityChange}
              disabled={!formData.provinsi}
              className="w-full p-2 border border-[#D5DBE7] rounded focus:outline-none focus:ring-1 focus:ring-blue-500"
            >
              <option value="">Pilih Kota</option>
              {cities.map((option) => (
                <option key={option.id} value={option.name}>{option.name}</option>
              ))}
            </select>
          </div>

          <div>
            <label className="block text-sm font-medium text-black mb-1">Kecamatan</label>
            <select
              name="kecamatan"
              value={formData.kecamatan}
              onChange={handleDistrictChange}
              disabled={!formData.kota}
              className="w-full p-2 border border-[#D5DBE7] rounded focus:outline-none focus:ring-1 focus:ring-blue-500"
            >
              <option value="">Pilih Kecamatan</option>
              {districts.map((option) => (
                <option key={option.id} value={option.name}>{option.name}</option>
              ))}
            </select>
          </div>

          <div>
            <label className="block text-sm font-medium text-black mb-1">Kode Pos</label>
            <input
              type="text"
              name="kode_pos"
              value={formData.kode_pos}
              onChange={handleChange}
              placeholder="Kode Pos"
              className="w-full p-2 border border-[#D5DBE7] rounded placeholder-[#667797] focus:outline-none focus:ring-1 focus:ring-blue-500"
            />
          </div>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
          {[{ label: "Email Perusahaan", name: "email_perusahaan" },
            { label: "Telepon Perusahaan", name: "telepon_perusahaan" },
            { label: "Website Perusahaan", name: "website_perusahaan" }]
            .map((field) => (
              <div key={field.name} className="w-full">
                <label className="block text-sm font-medium text-black mb-1">{field.label}</label>
                <input
                  type="text"
                  name={field.name}
                  value={formData[field.name]}
                  onChange={handleChange}
                  placeholder={field.label}
                  className="w-full p-2 border border-[#D5DBE7] rounded placeholder-[#667797] focus:outline-none focus:ring-1 focus:ring-blue-500"
                />
              </div>
            ))}
        </div>

        <div className="flex justify-end">
          <button
            type="submit"
            className="bg-sky-500 text-white font-bold py-2 px-6 rounded hover:bg-sky-700"
          >
            Simpan
          </button>
        </div>
      </form>
    </div>
  );
}
