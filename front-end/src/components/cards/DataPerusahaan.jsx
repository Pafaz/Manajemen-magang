import { useContext, useEffect, useState } from "react";
import axios from "axios";
import { useParams } from "react-router-dom";
import { AuthContext } from "../../contexts/AuthContext";

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

  const { userId } = useParams();
  const { token } = useContext(AuthContext);

  const [loading, setLoading] = useState(true);
  const [error, setError] = useState("");
  const [provinces, setProvinces] = useState([]);
  const [cities, setCities] = useState([]);
  const [districts, setDistricts] = useState([]);
  const [data, setData] = useState(null);
  console.log(data);

  useEffect(() => {
    async function fetchData() {
      try {
        const response = await axios.get(
          `${import.meta.env.VITE_API_URL}/peserta/${userId}`,
          {
            headers: { Authorization: `Bearer ${token}` },
          }
        );
        setData(response);
        console.log(response.data.data);
      } catch (err) {
        console.error(err);
        setError("Gagal memuat data perusahaan.");
      } finally {
        setLoading(false);
      }
    }

    async function fetchProvinces() {
      try {
        const res = await fetch(
          "https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json"
        );
        const data = await res.json();
        setProvinces(data);
      } catch (err) {
        console.error("Gagal memuat data provinsi", err);
      }
    }

    fetchData();
    fetchProvinces();
  }, [userId, token]);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData((prev) => ({ ...prev, [name]: value }));
  };

  const handleProvinceChange = async (e) => {
    const selected = provinces.find((p) => p.name === e.target.value);
    if (!selected) return;

    setFormData((prev) => ({
      ...prev,
      provinsi: selected.name,
      kota: "",
      kecamatan: "",
    }));

    try {
      const res = await fetch(
        `https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${selected.id}.json`
      );
      const data = await res.json();
      setCities(data);
      setDistricts([]);
    } catch (err) {
      console.error("Gagal memuat data kota/kabupaten", err);
    }
  };

  const handleCityChange = async (e) => {
    const selected = cities.find((c) => c.name === e.target.value);
    if (!selected) return;

    setFormData((prev) => ({
      ...prev,
      kota: selected.name,
      kecamatan: "",
    }));

    try {
      const res = await fetch(
        `https://www.emsifa.com/api-wilayah-indonesia/api/districts/${selected.id}.json`
      );
      const data = await res.json();
      setDistricts(data);
    } catch (err) {
      console.error("Gagal memuat data kecamatan", err);
    }
  };

  const handleDistrictChange = (e) => {
    const selected = districts.find((d) => d.name === e.target.value);
    if (!selected) return;

    setFormData((prev) => ({
      ...prev,
      kecamatan: selected.name,
    }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      await axios.put(
        `${import.meta.env.VITE_API_URL}/perusahaan/${userId}`,
        formData,
        {
          headers: { Authorization: `Bearer ${token}` },
        }
      );
      alert("Data perusahaan berhasil diperbarui!");
    } catch (err) {
      console.error(err);
      alert("Gagal memperbarui data perusahaan.");
    }
  };

  if (loading) return Skeleton();
  if (error) return <p className="text-red-500">{error}</p>;

  function Skeleton() {
    return (
      <div className="animate-pulse space-y-4 bg-white p-10 rounded-xl">
        {/* Baris pertama: Nama Penanggung Jawab */}
        <div className="h-6 bg-gray-300 rounded w-3/4"></div>
        <div className="h-6 bg-gray-300 rounded w-1/2"></div>
        <div className="h-6 bg-gray-300 rounded w-3/4"></div>
        <div className="h-6 bg-gray-300 rounded w-1/3"></div>

        {/* Baris kedua: Nama Perusahaan */}
        <div className="h-6 bg-gray-300 rounded w-3/4"></div>
        <div className="h-6 bg-gray-300 rounded w-1/2"></div>
        <div className="h-6 bg-gray-300 rounded w-3/4"></div>
        <div className="h-6 bg-gray-300 rounded w-1/3"></div>

        {/* Baris ketiga: Deskripsi Perusahaan */}
        <div className="h-16 bg-gray-300 rounded w-full"></div>

        {/* Baris keempat: Alamat Perusahaan */}
        <div className="h-16 bg-gray-300 rounded w-full"></div>

        {/* Baris kelima: Provinsi, Kota, Kecamatan */}
        <div className="grid grid-cols-3 gap-4">
          <div className="h-6 bg-gray-300 rounded w-full"></div>
          <div className="h-6 bg-gray-300 rounded w-full"></div>
          <div className="h-6 bg-gray-300 rounded w-full"></div>
        </div>

        {/* Baris keenam: Kode Pos, Email Perusahaan, Telepon Perusahaan */}
        <div className="grid grid-cols-3 gap-4">
          <div className="h-6 bg-gray-300 rounded w-full"></div>
          <div className="h-6 bg-gray-300 rounded w-full"></div>
          <div className="h-6 bg-gray-300 rounded w-full"></div>
        </div>

        {/* Button Skeleton */}
        <div className="h-10 bg-gray-300 rounded w-32"></div>
      </div>
    );
  }
  function Input({
    label,
    name,
    value,
    onChange,
    placeholder = "",
    type = "text",
  }) {
    return (
      <div className="w-full">
        <label className="block text-sm font-medium text-black mb-1">
          {label}
        </label>
        <input
          type={type}
          name={name}
          value={value}
          onChange={onChange}
          placeholder={placeholder}
          className="w-full p-2 border border-[#D5DBE7] rounded placeholder-[#667797] focus:outline-none focus:ring-1 focus:ring-blue-500"
        />
      </div>
    );
  }

  function Textarea({
    label,
    name,
    value,
    onChange,
    placeholder = "",
    rows = 4,
  }) {
    return (
      <div className="w-full">
        <label className="block text-sm font-medium text-black mb-1">
          {label}
        </label>
        <textarea
          name={name}
          value={value}
          onChange={onChange}
          placeholder={placeholder}
          rows={rows}
          className="w-full p-2 border border-[#D5DBE7] rounded placeholder-[#667797] focus:outline-none focus:ring-1 focus:ring-blue-500 resize-none"
        />
      </div>
    );
  }

  function Select({
    label,
    name,
    value,
    onChange,
    options = [],
    disabled = false,
  }) {
    return (
      <div className="w-full">
        <label className="block text-sm font-medium text-black mb-1">
          {label}
        </label>
        <select
          name={name}
          value={value}
          onChange={onChange}
          disabled={disabled}
          className="w-full p-2 border border-[#D5DBE7] rounded focus:outline-none focus:ring-1 focus:ring-blue-500"
        >
          <option value="">Pilih {label}</option>
          {options.map((option) => (
            <option key={option.id || option.name} value={option.name}>
              {option.name}
            </option>
          ))}
        </select>
      </div>
    );
  }

  return (
    <div className="bg-white rounded-lg shadow p-6 max-w-8xl mx-auto">
      <form onSubmit={handleSubmit}>
        <h2 className="text-lg font-bold mb-4">Data Umum Perusahaan</h2>

        <div className="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
          {[
            { label: "Nama Penanggung Jawab", name: "nama_penanggung_jawab" },
            {
              label: "Nomor HP Penanggung Jawab",
              name: "nohp_penanggung_jawab",
            },
            {
              label: "Jabatan Penanggung Jawab",
              name: "jabatan_penanggung_jawab",
            },
            { label: "Email Penanggung Jawab", name: "email_penanggung_jawab" },
          ].map((field) => (
            <Input
              key={field.name}
              label={field.label}
              name={field.name}
              value={formData[field.name]}
              onChange={handleChange}
            />
          ))}
        </div>

        <div className="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
          {[
            { label: "Nama Perusahaan", name: "nama_perusahaan" },
            { label: "Tanggal Berdiri", name: "tanggal_berdiri" },
            { label: "Bidang Usaha", name: "bidang_usaha" },
          ].map((field) => (
            <Input
              key={field.name}
              label={field.label}
              name={field.name}
              value={formData[field.name]}
              onChange={handleChange}
            />
          ))}
        </div>

        <div className="mb-6">
          <Textarea
            label="Deskripsi Perusahaan"
            name="deskripsi_perusahaan"
            value={formData.deskripsi_perusahaan}
            onChange={handleChange}
            placeholder="Tuliskan deskripsi perusahaan"
            rows={4}
          />
        </div>

        <h2 className="text-lg font-bold mb-4">Kontak Perusahaan</h2>

        <div className="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
          <div className="md:col-span-2">
            <Textarea
              label="Alamat Perusahaan"
              name="alamat_perusahaan"
              value={formData.alamat_perusahaan}
              onChange={handleChange}
              placeholder="Tuliskan alamat perusahaan"
              rows={2}
            />
          </div>

          <div>
            <Select
              label="Provinsi"
              name="provinsi"
              value={formData.provinsi}
              onChange={handleProvinceChange}
              options={provinces}
            />
          </div>

          <div>
            <Select
              label="Kabupaten/Kota"
              name="kota"
              value={formData.kota}
              onChange={handleCityChange}
              options={cities}
              disabled={!formData.provinsi}
            />
          </div>

          <div>
            <Select
              label="Kecamatan"
              name="kecamatan"
              value={formData.kecamatan}
              onChange={handleDistrictChange}
              options={districts}
              disabled={!formData.kota}
            />
          </div>

          <div>
            <Input
              label="Kode Pos"
              name="kode_pos"
              value={formData.kode_pos}
              onChange={handleChange}
            />
          </div>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
          {[
            { label: "Email Perusahaan", name: "email_perusahaan" },
            { label: "Telepon Perusahaan", name: "telepon_perusahaan" },
            { label: "Website Perusahaan", name: "website_perusahaan" },
          ].map((field) => (
            <Input
              key={field.name}
              label={field.label}
              name={field.name}
              value={formData[field.name]}
              onChange={handleChange}
            />
          ))}
        </div>

        <div className="mb-6">
          <h3 className="text-lg font-bold text-gray-800 mb-4">
            Dokumen Pendukung
          </h3>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            {/* Document 1 */}
            <div>
              <h4 className="text-sm font-medium text-[#667797] mb-2">
                Bukti Legalitas Perusahaan
              </h4>
              <div className="p-3">
                <div className="flex items-center mb-2">
                  <div className="h-16 w-16 mr-3 bg-gray-200 rounded overflow-hidden">
                    <img
                      src="/assets/img/Cover.png"
                      alt="Document preview"
                      className="w-full h-full object-cover"
                    />
                  </div>
                  <div className="flex-1">
                    <p className="font-medium text-xs text-[#667797]">
                      Bukti Legalitas Perusahaan
                    </p>
                    <p className="text-xs text-gray-500">Size: 23 kb</p>
                    <p className="text-xs text-gray-500">
                      Date Added: 25 Jun 2025
                    </p>
                  </div>
                  <div className="flex flex-col gap-2 items-end ml-3">
                    <button className="bg-blue-600 text-white text-xs rounded py-1 px-3 flex items-center gap-2">
                      <i className="bi bi-download"></i> Download
                    </button>
                    <button className="border border-gray-300 text-gray-600 text-xs rounded py-1 px-3 flex items-center gap-2">
                      <i className="bi bi-eye"></i> Preview
                    </button>
                  </div>
                </div>
              </div>
            </div>

            {/* Document 2 */}
            <div>
              <h4 className="text-sm font-medium text-black">
                Bukti NPWP Perusahaan
              </h4>
              <div className="p-3">
                <div className="flex items-center mb-2">
                  <div className="h-16 w-16 mr-3 bg-gray-200 rounded overflow-hidden">
                    <img
                      src="/assets/img/Cover.png"
                      alt="Document preview"
                      className="w-full h-full object-cover"
                    />
                  </div>
                  <div className="flex-1">
                    <p className="font-medium text-xs text-[#667797]">
                      Bukti NPWP Perusahaan
                    </p>
                    <p className="text-xs text-gray-500">Size: 25 kb</p>
                    <p className="text-xs text-gray-500">
                      Date Added: 25 Jun 2025
                    </p>
                  </div>
                  <div className="flex flex-col gap-2 items-end ml-3">
                    <button className="bg-blue-600 text-white text-xs rounded py-1 px-3 flex items-center gap-2">
                      <i className="bi bi-download"></i> Download
                    </button>
                    <button className="border border-gray-300 text-gray-600 text-xs rounded py-1 px-3 flex items-center gap-2">
                      <i className="bi bi-eye"></i> Preview
                    </button>
                  </div>
                </div>
              </div>
            </div>

            {/* Document 3 */}
            <div>
              <h4 className="text-sm font-medium text-black ">
                Profil Perusahaan Background
              </h4>
              <div className="p-3">
                <div className="flex items-center mb-2">
                  <div className="h-16 w-16 mr-3 bg-gray-200 rounded overflow-hidden">
                    <img
                      src="/assets/img/Cover.png"
                      alt="Document preview"
                      className="w-full h-full object-cover"
                    />
                  </div>
                  <div className="flex-1">
                    <p className="font-medium text-xs text-[#667797]">Cover</p>
                    <p className="text-xs text-gray-500">Size: 25 kb</p>
                    <p className="text-xs text-gray-500">
                      Date Added: 25 Jun 2025
                    </p>
                  </div>
                  <div className="flex flex-col gap-2 items-end ml-3">
                    <button className="bg-blue-600 text-white text-xs rounded py-1 px-3 flex items-center gap-2">
                      <i className="bi bi-download"></i> Download
                    </button>
                    <button className="border border-gray-300 text-gray-600 text-xs rounded py-1 px-3 flex items-center gap-2">
                      <i className="bi bi-eye"></i> Preview
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
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
