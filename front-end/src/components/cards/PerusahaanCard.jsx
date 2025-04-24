import { useState } from "react";

const CompanyCardWithModal = () => {
  // State untuk data perusahaan
  const [companyName, setCompanyName] = useState("PT. HUMMA TECHNOLOGY INDONESIA");
  const [description, setDescription] = useState(
    "Perusahaan ini bergerak di bidang Informasi dan Teknologi untuk perkembangan Industri"
  );
  const [location, setLocation] = useState("Malang, Indonesia");
  const [contactPerson, setContactPerson] = useState("Afrizal Hilmawan");

  // State untuk modal visibility
  const [isModalOpen, setIsModalOpen] = useState(false);
  
  // State untuk form data
  const [branchName, setBranchName] = useState("");
  const [businessField, setBusinessField] = useState("");
  const [address, setAddress] = useState("");
  const [charCount, setCharCount] = useState(0);
  const [websiteUrl, setWebsiteUrl] = useState("");
  const [instagramUrl, setInstagramUrl] = useState("");
  const [linkedinUrl, setLinkedinUrl] = useState("");

  // Fungsi untuk membuka modal
  const openModal = () => setIsModalOpen(true);

  // Fungsi untuk menutup modal
  const closeModal = () => setIsModalOpen(false);
  
  // Handle alamat change
  const handleAddressChange = (e) => {
    const text = e.target.value;
    setAddress(text);
    setCharCount(text.length);
  };

  return (
    <>
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
            onClick={openModal}
            className="text-white px-4 py-2 rounded text-sm self-end"
            style={{ backgroundColor: "#0069AB" }}
          >
            Tambah Cabang
          </button>
        </div>
      </div>

      {/* Modal */}
      {isModalOpen && (
        <div className="fixed inset-0 z-[999] flex items-center justify-center bg-black/50">
          <div className="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg mx-4">
            <div className="flex justify-between items-center mb-6">
              <h2 className="text-2xl font-bold">Tambah Cabang Perusahaan</h2>
              <button onClick={closeModal} className="text-gray-700 hover:text-gray-900">
                <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
              </button>
            </div>
            
            <form>
              <div className="mb-4">
                <label className="block text-gray-800 mb-2">Nama Cabang</label>
                <input
                  type="text"
                  value={branchName}
                  onChange={(e) => setBranchName(e.target.value)}
                  className="w-full border border-gray-300 rounded p-3 text-gray-600"
                  placeholder="Masukkan Nama Cabang"
                />
              </div>

              <div className="mb-4">
                <label className="block text-gray-800 mb-2">
                  Bidang Usaha<span className="text-red-500">*</span>
                </label>
                <div className="relative">
                  <select
                    value={businessField}
                    onChange={(e) => setBusinessField(e.target.value)}
                    className="w-full border border-gray-300 rounded p-3 pr-10 text-gray-600 appearance-none"
                  >
                    <option value="">Pilih Bidang Usaha</option>
                    <option value="Teknologi">Teknologi</option>
                    <option value="Retail">Retail</option>
                    <option value="Manufaktur">Manufaktur</option>
                  </select>
                  <div className="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <svg className="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                      <path fillRule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clipRule="evenodd"></path>
                    </svg>
                  </div>
                </div>
              </div>

              <div className="mb-4">
                <label className="block text-gray-800 mb-2">Alamat</label>
                <textarea
                  value={address}
                  onChange={handleAddressChange}
                  className="w-full border border-gray-300 rounded p-3 text-gray-600 h-24"
                  placeholder="Masukkan Alamat"
                ></textarea>
                <div className="flex justify-between text-xs text-gray-500 mt-1">
                  <span>Minimal Kata</span>
                  <span>{charCount}/100</span>
                </div>
              </div>

              <div className="mb-6">
                <label className="block text-gray-800 mb-2">Sosial Media Instalasi</label>
                <div className="flex flex-wrap gap-2">
                  <div className="relative flex-1">
                    <div className="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                      <i className="bi bi-globe text-blue-500"></i>
                    </div>
                    <input
                      type="text"
                      value={websiteUrl}
                      onChange={(e) => setWebsiteUrl(e.target.value)}
                      className="w-full border border-gray-300 rounded p-3 pl-10 text-gray-600"
                      placeholder="Website"
                    />
                  </div>
                  <div className="relative flex-1">
                    <div className="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                      <i className="bi bi-instagram text-pink-500"></i>
                    </div>
                    <input
                      type="text"
                      value={instagramUrl}
                      onChange={(e) => setInstagramUrl(e.target.value)}
                      className="w-full border border-gray-300 rounded p-3 pl-10 text-gray-600"
                      placeholder="Instagram"
                    />
                  </div>
                  <div className="relative flex-1">
                    <div className="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                      <i className="bi bi-linkedin text-blue-700"></i>
                    </div>
                    <input
                      type="text"
                      value={linkedinUrl}
                      onChange={(e) => setLinkedinUrl(e.target.value)}
                      className="w-full border border-gray-300 rounded p-3 pl-10 text-gray-600"
                      placeholder="LinkedIn"
                    />
                  </div>
                </div>
              </div>

              <div className="flex justify-end gap-3">
                <button
                  type="button"
                  onClick={closeModal}
                  className="bg-[#EA5455] text-white px-6 py-2 rounded-md"
                >
                  Batal
                </button>
                <button
                  type="submit" 
                  className="bg-[#0069AB] text-white px-6 py-2 rounded-md"
                >
                  Simpan
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </>
  );
};

export default CompanyCardWithModal;