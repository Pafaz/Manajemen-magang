import { useState, useEffect } from "react";
import { Trash2, Edit, ChevronDown, X } from "lucide-react";
import ModalDeleteAdminCabang from "../modal/ModalDeleteAdminCabang";
import axios from "axios";

export default function UniversityCardGrid() {
  const [partners, setPartners] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  const [showCategoryDropdown, setShowCategoryDropdown] = useState(false);
  const [selectedCategory, setSelectedCategory] = useState("All");

  const [showModal, setShowModal] = useState(false);
  const [editingPartner, setEditingPartner] = useState(null);
  const [formData, setFormData] = useState({
    nama: "",
    alamat: "",
    telepon: "",
    jenis_institusi: "",
    website: "",
    foto_header: null,
    jurusan: [],
  });

  const [showDeleteModal, setShowDeleteModal] = useState(false);
  const [partnerToDelete, setPartnerToDelete] = useState(null);

  const categories = ["All", "Sekolah", "Perusahaan", "Lembaga"];
  const majorsList = [
    "Informatika",
    "Agribusiness",
    "Manajemen",
    // …etc
  ];

  // Fetch all mitra
  useEffect(() => {
    (async () => {
      try {
        const { data } = await axios.get(
          `${import.meta.env.VITE_API_URL}/mitra`,
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          }
        );
        setPartners(data.data);
      } catch (err) {
        console.error(err);
        setError("Gagal memuat data mitra.");
      } finally {
        setLoading(false);
      }
    })();
  }, []);

  const refresh = async () => {
    setLoading(true);
    try {
      const { data } = await axios.get(
        `${import.meta.env.VITE_API_URL}/mitra`,
        {
          headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
        }
      );
      setPartners(data.data);
    } catch (_) {
      setError("Gagal memuat ulang.");
    } finally {
      setLoading(false);
    }
  };

  const filtered =
    selectedCategory === "All"
      ? partners
      : partners.filter((p) => p.jenis_institusi === selectedCategory);

  const openAdd = () => {
    setEditingPartner(null);
    setFormData({
      nama: "",
      alamat: "",
      telepon: "",
      jenis_institusi: "",
      website: "",
      foto_header: null,
      jurusan: [],
    });
    setShowModal(true);
  };

  const openEdit = (p) => {
    setEditingPartner(p);
    setFormData({
      nama: p.nama,
      alamat: p.alamat,
      telepon: p.telepon,
      jenis_institusi: p.jenis_institusi,
      website: p.website || "",
      foto_header: null,
      jurusan: p.jurusan.map((j) => j.nama),
    });
    setShowModal(true);
  };

  const handleFormChange = (e) => {
    const { name, value, files, multiple, selectedOptions } = e.target;
    if (name === "foto_header") {
      setFormData((f) => ({ ...f, foto_header: files[0] }));
    } else if (multiple) {
      setFormData((f) => ({
        ...f,
        jurusan: Array.from(selectedOptions, (o) => o.value),
      }));
    } else {
      setFormData((f) => ({ ...f, [name]: value }));
    }
  };

  const savePartner = async (e) => {
    e.preventDefault();
    const fd = new FormData();
    fd.append("nama", formData.nama);
    fd.append("alamat", formData.alamat);
    fd.append("telepon", formData.telepon);
    fd.append("jenis_institusi", formData.jenis_institusi);
    if (formData.website) fd.append("website", formData.website);
    if (formData.foto_header) fd.append("foto_header", formData.foto_header);
    formData.jurusan.forEach((j) => fd.append("jurusan[]", j));
  
    fd.append("_method", "PUT");
  
    try {
      if (editingPartner) {
        const response = await axios.put(
          `${import.meta.env.VITE_API_URL}/mitra/${editingPartner.id}`,
          fd,
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
              "Content-Type": "multipart/form-data",
            },
          }
        );
        if (response.status === 200) {
          setShowModal(false);
          refresh();
        }
      } else {
        const response = await axios.post(
          `${import.meta.env.VITE_API_URL}/mitra`,
          fd,
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
              "Content-Type": "multipart/form-data",
            },
          }
        );
        if (response.status === 200) {
          setShowModal(false);
          refresh();
        }
      }
    } catch (err) {
      console.error("Gagal menyimpan mitra:", err);
    }
  };
  

  const confirmDelete = async (p) => {
    const confirmed = window.confirm(`Yakin ingin menghapus mitra "${p.nama}"?`);
    if (confirmed) {
      try {
        await axios.delete(
          `${import.meta.env.VITE_API_URL}/mitra/${p.id}`,
          {
            headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
          }
        );
        refresh();
      } catch (err) {
        console.error("Gagal menghapus mitra:", err);
      }
    }
  };
  

  // const handleDelete = async () => {
  //   try {
  //     await axios.delete(
  //       `${import.meta.env.VITE_API_URL}/mitra/${partnerToDelete.id}`,
  //       {
  //         headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
  //       }
  //     );
  //     setShowDeleteModal(false);
  //     refresh();
  //   } catch (err) {
  //     console.error("Gagal menghapus mitra:", err);
  //   }
  // };

  if (loading) return <div className="h-screen">Loading...</div>;
  if (error) return <div className="text-red-500">{error}</div>;
  
  return (
    <div className="p-2 min-h-screen">
      <div className="max-w-9xl mx-auto space-y-6">
        <div className="bg-white p-4 rounded-lg shadow-md">
          <div className="flex justify-between items-center mb-3">
            <h2 className="text-lg font-bold text-black-800">
              Mitra Terdaftar
            </h2>
            <div className="flex items-center space-x-2">
              <button
                className="bg-white px-2 py-1 rounded-md text-xs border border-gray-300 text-gray-700 hover:bg-gray-50 flex items-center"
                onClick={(e) => {
                  e.stopPropagation();
                  openAdd();
                }}
              >
                <span className="mr-1">+</span> Tambah Mitra
              </button>
              <div className="relative">
                <button
                  className="bg-white px-2 py-1 rounded-md text-xs border border-gray-300 text-gray-700 flex items-center"
                  onClick={(e) => {
                    e.stopPropagation();
                    setShowCategoryDropdown((v) => !v);
                  }}
                >
                  <span>Category: {selectedCategory}</span>
                  <ChevronDown size={14} className="ml-1" />
                </button>
                {showCategoryDropdown && (
                  <div className="absolute right-0 mt-1 w-32 bg-white rounded-md shadow-lg z-10 border border-gray-200">
                    <ul className="py-1">
                      {categories.map((cat) => (
                        <li
                          key={cat}
                          className="px-3 py-1 text-xs text-gray-700 hover:bg-gray-100 cursor-pointer"
                          onClick={() => handleSelectCategory(cat)}
                        >
                          {cat}
                        </li>
                      ))}
                    </ul>
                  </div>
                )}
              </div>
            </div>
          </div>

          <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
            {filtered.map((university) => (
              <div
                key={university.id}
                className="bg-white rounded-lg border border-gray-200 overflow-hidden flex flex-col h-full"
              >
                <div className="relative">
                  <img
                     src={`http://127.0.0.1:8000/storage/${university.foto[0].path}`} 
                    alt="Cover"
                    className="w-full h-32 object-cover"
                  />
                  <div className="absolute -bottom-6 left-1/2 transform -translate-x-1/2 w-12 h-12 rounded-full bg-purple-500 border-2 border-white flex items-center justify-center">
                    <img
                       src={`http://127.0.0.1:8000/storage/${university.foto[0].path}`} 
                      alt="Logo"
                      className="w-10 h-10 object-cover rounded-full"
                    />
                  </div>
                </div>
                <div className="pt-8 px-3 text-center flex-grow">
                  <h3 className="font-bold text-base mb-2">
                    {university.nama}
                  </h3>
                  <p className="text-gray-500 text-xs mb-2">
                    {university.alamat}
                  </p>
                  <p className="text-xs text-gray-700 mb-4 line-clamp-3">
                    {university.jurusan.map((j) => j.nama).join(", ")}
                  </p>
                </div>
                <div className="mt-auto flex border-t border-gray-200">
                  <button
                    className="flex-1 py-2 flex items-center justify-center text-gray-500 text-xs hover:bg-gray-50"
                    onClick={() => confirmDelete(university)}
                  >
                    <Trash2 size={14} className="mr-1" /> Hapus
                  </button>
                  <div className="w-px bg-gray-200" />
                  <button
                    className="flex-1 py-2 flex items-center justify-center text-yellow-500 text-xs hover:bg-gray-50"
                    onClick={() => openEdit(university)}
                  >
                    <Edit size={14} className="mr-1" /> Edit
                  </button>
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>

      {showModal && (
        <div className="fixed inset-0 bg-black/40 flex justify-center items-center z-[999]">
          <div className="bg-white rounded-lg w-full max-w-md">
            <div className="flex justify-between items-center p-4 border-b border-gray-200">
              <h2 className="text-lg font-bold text-gray-800">
                {editingPartner ? "Edit Mitra" : "Tambahkan Mitra Baru"}
              </h2>
              <button
                onClick={() => setShowModal(false)}
                className="text-gray-500 hover:text-gray-700"
              >
                <X size={20} />
              </button>
            </div>
            <form onSubmit={savePartner} className="p-4 space-y-4">
              <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">
                    Nama Mitra
                  </label>
                  <input
                    type="text"
                    name="nama"
                    value={formData.nama}
                    onChange={handleFormChange}
                    placeholder="Masukkan nama mitra"
                    className="w-full p-2 border border-gray-300 rounded-md text-sm"
                    required
                  />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">
                    Telepon
                  </label>
                  <input
                    type="text"
                    name="telepon"
                    value={formData.telepon}
                    onChange={handleFormChange}
                    placeholder="Masukkan nomor telepon"
                    className="w-full p-2 border border-gray-300 rounded-md text-sm"
                    required
                  />
                </div>
              </div>

              <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">
                    Website (opsional)
                  </label>
                  <input
                    type="url"
                    name="website"
                    value={formData.website}
                    onChange={handleFormChange}
                    placeholder="Masukkan link"
                    className="w-full p-2 border border-gray-300 rounded-md text-sm"
                  />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">
                    Jenis Institusi
                  </label>
                  <select
                    name="jenis_institusi"
                    value={formData.jenis_institusi}
                    onChange={handleFormChange}
                    className="w-full p-2 border border-gray-300 rounded-md text-sm"
                    required
                  >
                    <option value="">Pilih jenis</option>
                    {categories
                      .filter((c) => c !== "All")
                      .map((c) => (
                        <option key={c} value={c}>
                          {c}
                        </option>
                      ))}
                  </select>
                </div>
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">
                  Alamat
                </label>
                <textarea
                  name="alamat"
                  value={formData.alamat}
                  onChange={handleFormChange}
                  placeholder="Masukkan alamat"
                  className="w-full p-2 border border-gray-300 rounded-md text-sm"
                  required
                />
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">
                  Foto Header
                </label>
                <input
                  type="file"
                  name="foto_header"
                  onChange={handleFormChange}
                  className="w-full p-2 border border-gray-300 rounded-md text-sm"
                  {...(editingPartner ? {} : { required: true })}
                />
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">
                  Jurusan
                </label>
                <select
                  name="jurusan"
                  multiple
                  value={formData.jurusan}
                  onChange={handleFormChange}
                  className="w-full p-2 border border-gray-300 rounded-md text-sm"
                  required
                >
                  {majorsList.map((m) => (
                    <option key={m} value={m}>
                      {m}
                    </option>
                  ))}
                </select>
              </div>

              <div className="flex justify-end space-x-2">
                <button
                  type="button"
                  onClick={() => setShowModal(false)}
                  className="px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-700"
                >
                  Batal
                </button>
                <button
                  type="submit"
                  className="px-4 py-2 bg-blue-500 text-white rounded-md text-sm"
                >
                  Simpan
                </button>
              </div>
            </form>
          </div>
        </div>
      )}

      {/* {showDeleteModal && partnerToDelete && (
        <ModalDeleteAdminCabang
          isOpen={showDeleteModal}
          onClose={() => setShowDeleteModal(false)}
          onDelete={handleDelete}
          partner={partnerToDelete}
        />
      )} */}
    </div>
  );
}
