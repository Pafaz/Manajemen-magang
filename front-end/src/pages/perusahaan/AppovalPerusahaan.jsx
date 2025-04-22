import { useState } from "react";
import DataApproval from "../../components/cards/DataApproval"; // Pastikan komponen ini ada

const Approval = () => {
  // State untuk data perusahaan
  const [companyName, setCompanyName] = useState("PT. HUMMA TECHNOLOGY INDONESIA");
  const [description, setDescription] = useState(
    "Perusahaan ini bergerak di bidang Informasi dan Teknologi untuk perkembangan Industri"
  );
  const [location, setLocation] = useState("Malang, Indonesia");
  const [contactPerson, setContactPerson] = useState("Afrizal Hilmawan");

  // State untuk modal visibility
  const [isModalOpen, setIsModalOpen] = useState(false);

  // Fungsi untuk membuka modal
  const openModal = () => setIsModalOpen(true);

  // Fungsi untuk menutup modal
  const closeModal = () => setIsModalOpen(false);

  return (
    <div className="p-6">
      {/* Kartu utama */}
      <div className="bg-white rounded-lg shadow-md overflow-hidden">
        {/* Gambar Header */}
        <div>
          <img
            src="/assets/img/Cover.png"
            alt="Cover"
            className="w-full h-60 object-cover"
          />
        </div>

        {/* Info Perusahaan */}
        <div className="w-full px-6 pt-4 pb-4 flex justify-between items-start">
          {/* Logo dan info */}
          <div className="flex items-start gap-4">
            <img
              src="/assets/img/logoperusahaan.png"
              alt="Logo"
              className="w-14 h-14 rounded-full border border-gray-200"
            />

            <div>
              <h2 className="text-lg font-semibold text-gray-800">{companyName}</h2>
              <p className="text-sm text-gray-600">{description}</p>

              {/* Lokasi dan Kontak */}
              <div className="text-xs text-gray-500 flex items-center gap-2 mt-1">
                <span className="flex items-center gap-1">
                  <i className="bi bi-geo-alt-fill"></i> {location}
                </span>
                |
                <span className="flex items-center gap-1">
                  <i className="bi bi-person-fill"></i> {contactPerson}
                </span>
              </div>

              {/* Link Sosial Media */}
              <div className="flex items-center gap-4 mt-2 text-gray-600 text-sm">
                <a
                  href="https://www.humma.co.id"
                  target="_blank"
                  rel="noopener noreferrer"
                  className="hover:text-blue-600"
                >
                  <i className="bi bi-globe"></i>
                </a>
                <a
                  href="https://www.instagram.com/humma.id"
                  target="_blank"
                  rel="noopener noreferrer"
                  className="hover:text-pink-600"
                >
                  <i className="bi bi-instagram"></i>
                </a>
                <a
                  href="https://www.linkedin.com/company/humma-id"
                  target="_blank"
                  rel="noopener noreferrer"
                  className="hover:text-blue-700"
                >
                  <i className="bi bi-linkedin"></i>
                </a>
              </div>
            </div>
          </div>

          {/* Tombol Tambah Cabang */}
          <button
            onClick={openModal}  // Open modal on click
            className="text-white px-4 py-2 rounded text-sm self-end"
            style={{ backgroundColor: "#0069AB" }}
          >
            Tambah Cabang
          </button>
        </div>
      </div>

      {/* Komponen DataApproval */}
      <div className="mt-8 px-1 pb-6">
        <DataApproval />
      </div>

      {/* Modal */}
      {isModalOpen && (
        <div className="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50">
          <div className="bg-white p-6 rounded-lg shadow-lg w-96">
            <div className="flex justify-between items-center">
              <h2 className="text-xl font-semibold">Tambah Cabang Perusahaan</h2>
              <button onClick={closeModal} className="text-xl font-semibold">X</button>
            </div>
            <form>
              <div className="mt-4">
                <label className="block text-sm font-medium text-gray-600">Nama Cabang</label>
                <input
                  type="text"
                  className="w-full p-2 mt-2 border border-gray-300 rounded"
                  placeholder="Masukkan Nama Cabang"
                />
              </div>

              <div className="mt-4">
                <label className="block text-sm font-medium text-gray-600">Bidang Usaha</label>
                <select className="w-full p-2 mt-2 border border-gray-300 rounded">
                  <option>Pilih Bidang Usaha</option>
                  <option>Teknologi</option>
                  <option>Retail</option>
                  <option>Manufaktur</option>
                </select>
              </div>

              <div className="mt-4">
                <label className="block text-sm font-medium text-gray-600">Alamat</label>
                <textarea
                  className="w-full p-2 mt-2 border border-gray-300 rounded"
                  placeholder="Masukkan Alamat"
                ></textarea>
              </div>

              <div className="mt-4">
                <label className="block text-sm font-medium text-gray-600">Social Media Instalasi</label>
                <div className="flex gap-4 mt-2">
                  <button className="bg-blue-500 text-white px-4 py-2 rounded">Website</button>
                  <button className="bg-pink-500 text-white px-4 py-2 rounded">Instagram</button>
                  <button className="bg-blue-700 text-white px-4 py-2 rounded">LinkedIn</button>
                </div>
              </div>

              <div className="mt-6 flex justify-between">
                <button
                  type="button"
                  onClick={closeModal}
                  className="bg-red-500 text-white px-4 py-2 rounded"
                >
                  Batal
                </button>
                <button
                  type="submit"
                  className="bg-blue-600 text-white px-4 py-2 rounded"
                >
                  Simpan
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
};

export default Approval;
