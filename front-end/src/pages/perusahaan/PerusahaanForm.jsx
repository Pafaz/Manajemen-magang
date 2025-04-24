import { useEffect, useState } from "react";
import { Calendar, Upload } from "lucide-react";

export default function CompanyRegistrationForm() {
  const [provinces, setProvinces] = useState([]);
  const [cities, setCities] = useState([]);
  const [selectedProvince, setSelectedProvince] = useState("");
  const [districts, setDistricts] = useState([]);
  const [selectedCity, setSelectedCity] = useState("");

  const [formData, setFormData] = useState({
    // General Company Data
    ownerName: "",
    ownerPhone: "",
    ownerPosition: "",
    ownerEmail: "",
    companyName: "",
    dateEstablished: "",
    businessField: "",

    // Contact Information
    companyAddress: "",
    province: "",
    city: "",
    postalCode: "",
    district: "",
    website: "",
    companyEmail: "",
    companyPhone: "",
  });

  useEffect(() => {
    fetch("https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json")
      .then((response) => response.json())
      .then((data) => setProvinces(data))
      .catch((error) => console.error("Error fetching provinces:", error));
  }, []);

  const handleProvinceChange = (event) => {
    const provinceId = event.target.value;
    setSelectedProvince(provinceId);
    setSelectedCity("");

    if (provinceId) {
      fetch(
        `https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`
      )
        .then((response) => response.json())
        .then((data) => setCities(data))
        .catch((error) => console.error("Error fetching cities:", error));
    }
  };

  const handleCityChange = (event) => {
    const cityId = event.target.value;
    setSelectedCity(cityId);

    if (cityId) {
      fetch(
        `https://www.emsifa.com/api-wilayah-indonesia/api/districts/${cityId}.json`
      )
        .then((response) => response.json())
        .then((data) => setDistricts(data))
        .catch((error) => console.error("Error fetching districts:", error));
    }
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData((prev) => ({
      ...prev,
      [name]: value,
      ...(name === "province" && { city: "", district: "" }),
      ...(name === "city" && { district: "" }),
    }));
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    console.log(formData);
    // Handle form submission
  };

  return (
    <div className="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-sm">
      <form onSubmit={handleSubmit}>
        {/* Header Section */}
        <div className="mb-6">
          <h1 className="text-xl font-bold text-gray-800">
            Data Umum Perusahaan
          </h1>
          <p className="text-sm text-gray-500">
            Silahkan Lengkapi Data Terlebih Dahulu
          </p>
        </div>

        <div className="border-t border-gray-200 my-6"></div>

        {/* General Company Data Section */}
        <div className="mb-8">
          <h2 className="text-lg font-bold text-gray-800 mb-4">
            Data Umum Perusahaan
          </h2>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div className="space-y-2">
              <label className="block text-sm font-medium text-gray-700">
                Nama Penanggung Jawab<span className="text-red-500">*</span>
              </label>
              <input
                type="text"
                name="ownerName"
                placeholder="Masukkan Nama"
                className="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                value={formData.ownerName}
                onChange={handleChange}
                required
              />
            </div>

            <div className="space-y-2">
              <label className="block text-sm font-medium text-gray-700">
                Nomor HP Penanggung Jawab<span className="text-red-500">*</span>
              </label>
              <input
                type="text"
                name="ownerPhone"
                placeholder="Masukkan Nomor HP"
                className="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                value={formData.ownerPhone}
                onChange={handleChange}
                required
              />
            </div>

            <div className="space-y-2">
              <label className="block text-sm font-medium text-gray-700">
                Jabatan Penanggung Jawab<span className="text-red-500">*</span>
              </label>
              <select
                name="ownerPosition"
                className="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white"
                value={formData.ownerPosition}
                onChange={handleChange}
                required
              >
                <option value="">Pilih Jabatan</option>
                <option value="direktur">Direktur</option>
                <option value="manager">Manager</option>
                <option value="supervisor">Supervisor</option>
              </select>
            </div>

            <div className="space-y-2">
              <label className="block text-sm font-medium text-gray-700">
                Email Penanggung Jawab<span className="text-red-500">*</span>
              </label>
              <input
                type="email"
                name="ownerEmail"
                placeholder="Masukkan Email"
                className="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                value={formData.ownerEmail}
                onChange={handleChange}
                required
              />
            </div>

            <div className="space-y-2">
              <label className="block text-sm font-medium text-gray-700">
                Nama Perusahaan<span className="text-red-500">*</span>
              </label>
              <input
                type="text"
                name="companyName"
                placeholder="Masukkan Nama Perusahaan"
                className="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                value={formData.companyName}
                onChange={handleChange}
                required
              />
            </div>

            <div className="space-y-2">
              <label className="block text-sm font-medium text-gray-700">
                Tanggal Berdiri<span className="text-red-500">*</span>
              </label>
              <div className="relative">
                <input
                  type="date"
                  name="dateEstablished"
                  placeholder="Tanggal Berdiri"
                  className="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  value={formData.dateEstablished}
                  onChange={handleChange}
                  required
                />
                <Calendar className="absolute right-2 top-2.5 h-5 w-5 text-gray-400" />
              </div>
            </div>

            <div className="space-y-2">
              <label className="block text-sm font-medium text-gray-700">
                Bidang Usaha<span className="text-red-500">*</span>
              </label>
              <select
                name="businessField"
                className="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white"
                value={formData.businessField}
                onChange={handleChange}
                required
              >
                <option value="">Pilih Bidang Usaha</option>
                <option value="teknologi">Teknologi</option>
                <option value="manufaktur">Manufaktur</option>
                <option value="jasa">Jasa</option>
                <option value="perdagangan">Perdagangan</option>
              </select>
            </div>
          </div>
          <div className="grid grid-cols-2 gap-3 mt-5">
            <textarea
              className="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white"
              name=""
              id=""
              placeholder="Deskripsi Perusahaan"
            ></textarea>
          </div>
        </div>

        {/* Contact Information Section */}
        <div className="mb-8">
          <h2 className="text-lg font-bold text-gray-800 mb-4">
            Kontak Perusahaan
          </h2>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
          <div className="space-y-2">
              <label className="block text-sm font-medium text-gray-700">
                Provinsi<span className="text-red-500">*</span>
              </label>
              <select
                name="province"
                className="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white"
                value={selectedProvince}
                onChange={handleProvinceChange}
                required
              >
                <option value="">Pilih Provinsi</option>
                {provinces.map((province) => (
                  <option key={province.id} value={province.id}>
                    {province.name}
                  </option>
                ))}
              </select>
            </div>

            <div className="space-y-2">
              <label className="block text-sm font-medium text-gray-700">
                Kabupaten/Kota<span className="text-red-500">*</span>
              </label>
              <select
                name="city"
                className="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white"
                value={selectedCity}
                onChange={handleCityChange}
                required
              >
                <option value="#">Pilih Kabupaten/Kota</option>
                {cities.map((city) => (
                  <option key={city.id} value={city.id}>
                    {city.name}
                  </option>
                ))}
              </select>
            </div>

            <div className="space-y-2">
              <label className="block text-sm font-medium text-gray-700">
                Kecamatan<span className="text-red-500">*</span>
              </label>
              <select
                name="district"
                className="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white"
                value={formData.district}
                onChange={handleChange}
                required
              >
                <option value="#">Pilih Kecamatan</option>
                {districts.map((district) => (
                  <option key={district.id} value={district.id}>
                    {district.name}
                  </option>
                ))}
              </select>
            </div>

            <div className="space-y-2">
              <label className="block text-sm font-medium text-gray-700">
                Kode Pos<span className="text-red-500">*</span>
              </label>
              <input
                type="text"
                name="postalCode"
                placeholder="Masukkan Kode Pos"
                className="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                value={formData.postalCode}
                onChange={handleChange}
                required
              />
            </div>

            <div className="space-y-2">
              <label className="block text-sm font-medium text-gray-700">
                Email Perusahaan<span className="text-red-500">*</span>
              </label>
              <input
                type="email"
                name="companyEmail"
                placeholder="Email Perusahaan"
                className="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                value={formData.companyEmail}
                onChange={handleChange}
                required
              />
            </div>

            <div className="space-y-2">
              <label className="block text-sm font-medium text-gray-700">
                Nomor Telepon Perusahaan<span className="text-red-500">*</span>
              </label>
              <input
                type="text"
                name="companyPhone"
                placeholder="Masukkan Nomor Telepon"
                className="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                value={formData.companyPhone}
                onChange={handleChange}
                required
              />
            </div>  

            <div className="space-y-2">
              <label className="block text-sm font-medium text-gray-700">
                Website Perusahaan<span className="text-red-500">*</span>
              </label>
              <input
                type="text"
                name="website"
                placeholder="Website Perusahaan"
                className="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                value={formData.website}
                onChange={handleChange}
                required
              />
            </div>
          </div>
          <div className="grid grid-cols-2 gap-3 mt-5">
            <textarea
              className="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white"
              name=""
              id=""
              placeholder="Alamat Perusahaan"
            ></textarea>
          </div>
        </div>

        {/* Document Upload Section */}
        <div className="mb-8">
          <div className="relative">
            <h2 className="text-lg font-bold text-gray-800 mb-4">
              Dokumen Pendukung (opsional)
            </h2>
            <div className="absolute top-0 right-0 bg-green-500 text-white rounded-full h-6 w-6 flex items-center justify-center">
              <span>A</span>
            </div>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div className="space-y-2">
              <label className="block text-sm font-medium text-gray-700">
                Bukti Legalitas Perusahaan
              </label>
              <div className="flex flex-col gap-2">
                <div className="border border-gray-300 rounded-md p-2 flex items-center justify-between">
                  <button className="text-sm px-4 py-1 bg-blue-100 text-blue-700 rounded-md">
                    Choose File
                  </button>
                  <span className="text-sm text-gray-500">No File Chosen</span>
                </div>
                <p className="text-xs text-red-500">
                  *Foto Harus Berformat .jpg, .jpeg, atau .png
                </p>
              </div>
            </div>

            <div className="space-y-2">
              <label className="block text-sm font-medium text-gray-700">
                Bukti NPWP Perusahaan
              </label>
              <div className="flex flex-col gap-2">
                <div className="border border-gray-300 rounded-md p-2 flex items-center justify-between">
                  <button className="text-sm px-4 py-1 bg-blue-100 text-blue-700 rounded-md">
                    Choose File
                  </button>
                  <span className="text-sm text-gray-500">No File Chosen</span>
                </div>
                <p className="text-xs text-red-500">
                  *Foto Harus Berformat .jpg, .jpeg, atau .png
                </p>
              </div>
            </div>

            <div className="space-y-2">
              <label className="block text-sm font-medium text-gray-700">
                Bukti Logo Perusahaan
              </label>
              <div className="flex flex-col gap-2">
                <div className="border border-gray-300 rounded-md p-2 flex items-center justify-between">
                  <button className="text-sm px-4 py-1 bg-blue-100 text-blue-700 rounded-md">
                    Choose File
                  </button>
                  <span className="text-sm text-gray-500">No File Chosen</span>
                </div>
                <p className="text-xs text-red-500">
                  *Foto Harus Berformat .jpg, .jpeg, atau .png
                </p>
              </div>
            </div>
          </div>
        </div>

        <div className="flex justify-end">
          <button
            type="submit"
            className="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            Submit
          </button>
        </div>
      </form>
    </div>
  );
}
