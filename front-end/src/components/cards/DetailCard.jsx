import { useState, useEffect } from "react";
import CompanyBranchCard from "../../components/cards/CompanyBranchCard"; // sesuaikan path
import MentorBranchCard from "../../components/cards/MentorBranchCard"; // sesuaikan path
import PesertaBranchCard from "../../components/cards/PesertaBranchCard"; // sesuaikan path
import DivisiBranchCard from "../../components/cards/DivisiBranchCard";

const CompanyCard = () => {
  const [companyName, setCompanyName] = useState("PT. HUMMA TECHNOLOGY INDONESIA");
  const [description, setDescription] = useState("Perusahaan ini bergerak di bidang Informasi dan Teknologi untuk perkembangan Industri");
  const [location, setLocation] = useState("Malang, Indonesia");
  const [contactPerson, setContactPerson] = useState("Afrizal Hilmawan");

  const [branchName, setBranchName] = useState("");
  const [businessField, setBusinessField] = useState("");
  const [address, setAddress] = useState("");
  const [charCount, setCharCount] = useState(0);
  const [websiteUrl, setWebsiteUrl] = useState("");
  const [instagramUrl, setInstagramUrl] = useState("");
  const [linkedinUrl, setLinkedinUrl] = useState("");

  // Inisialisasi activeMenu dengan nilai dari localStorage atau default ke "Admin Cabang"
  const [activeMenu, setActiveMenu] = useState(() => {
    const savedMenu = localStorage.getItem("activeMenu");
    return savedMenu || "Admin Cabang";
  });

  // State untuk animasi konten
  const [animating, setAnimating] = useState(false);

  // Menyimpan activeMenu ke localStorage setiap kali berubah
  useEffect(() => {
    localStorage.setItem("activeMenu", activeMenu);
  }, [activeMenu]);

  const handleAddressChange = (e) => {
    const text = e.target.value;
    setAddress(text);
    setCharCount(text.length);
  };

  const handleMenuClick = (menuName) => {
    if (menuName !== activeMenu) {
      setAnimating(true);

      // Menunda perubahan menu aktif untuk memberikan waktu animasi fade out
      setTimeout(() => {
        setActiveMenu(menuName);
        // Menunda penghapusan kelas animasi setelah konten baru dimuat
        setTimeout(() => {
          setAnimating(false);
        }, 50);
      }, 300);
    }
  };

  // Menu items array
  const menuItems = ["Admin Cabang", "Mentor", "Peserta Magang", "Divisi", "Approval", "Jurnal", "Absensi", "Surat", "Lembaga", "rfid", "Kategori Project", "Piket"];

  return (
    <>
      {/* Bagian Atas (Header + Menu Bar) */}
      <div className="bg-white rounded-lg overflow-hidden">
        <div>
          <img src="/assets/img/Cover.png" alt="Cover" className="w-full h-60 object-cover" />
        </div>

        <div className="w-full px-6 pt-4 pb-4 flex justify-between items-start">
          <div className="flex items-start gap-4">
            <img src="/assets/img/logoperusahaan.png" alt="Logo" className="w-14 h-14 rounded-full border border-gray-200" />

            <div>
              <h2 className="text-lg font-semibold text-gray-800">{companyName}</h2>
              <p className="text-[13px] text-gray-600">{description}</p>

              <div className="text-[13px] text-gray-500 flex items-center gap-2 mt-1">
                <span className="flex items-center gap-1">
                  <i className="bi bi-geo-alt-fill"></i> {location}
                </span>
                |
                <span className="flex items-center gap-1">
                  <i className="bi bi-person-fill"></i> {contactPerson}
                </span>
              </div>

              <div className="flex items-center gap-4 mt-2 text-gray-600 text-[13px]">
                <a href="https://www.humma.co.id" target="_blank" rel="noopener noreferrer" className="hover:text-blue-600">
                  <i className="bi bi-globe"></i>
                </a>
                <a href="https://www.instagram.com/humma.id" target="_blank" rel="noopener noreferrer" className="hover:text-pink-600">
                  <i className="bi bi-instagram"></i>
                </a>
                <a href="https://www.linkedin.com/company/humma-id" target="_blank" rel="noopener noreferrer" className="hover:text-blue-700">
                  <i className="bi bi-linkedin"></i>
                </a>
              </div>
            </div>
          </div>
        </div>

        <div className="flex gap-1 mt-2 mb-0 px-6 overflow-x-auto">
          {menuItems.map((menuName, index) => (
            <div
              key={index}
              className={`px-3 py-1.5 cursor-pointer rounded-t-lg transition-all duration-300 ease-in-out ${
                activeMenu === menuName ? "bg-[#ECF2FE] text-[#0069AB] font-medium transform scale-105" : "bg-white-100 text-black-600 hover:bg-[#ECF2FE] hover:text-[#0069AB]"
              }`}
              onClick={() => handleMenuClick(menuName)}
            >
              <span className="text-[13px] font-medium relative">
                {menuName === "rfid" ? "RFID" : menuName}
                {activeMenu === menuName && <span className="absolute bottom-0 left-0 w-full h-0.5 bg-[#0069AB] rounded-full"></span>}
              </span>
            </div>
          ))}
        </div>
      </div>

      {/* Konten dengan efek bounce */}
      <div className="bg-[#ECF2FE] pt-4 pb-4 overflow-hidden">
        <div className={`transition-all duration-300 ease-in-out transform ${animating ? "opacity-0 translate-y-8" : "opacity-100 translate-y-0 animate-bounce-in"}`}>
          {activeMenu === "Admin Cabang" && <CompanyBranchCard />}
          {activeMenu === "Mentor" && <MentorBranchCard />}
          {activeMenu === "Peserta Magang" && <PesertaBranchCard />}
          {activeMenu === "Divisi" && <DivisiBranchCard />}
          {activeMenu === "Approval" && <div>Approval Content</div>}
          {activeMenu === "Jurnal" && <div>Jurnal Content</div>}
          {activeMenu === "Absensi" && <div>Absensi Content</div>}
          {activeMenu === "Surat" && <div>Surat Content</div>}
          {activeMenu === "Lembaga" && <div>Lembaga Content</div>}
          {activeMenu === "rfid" && <div>RFID Content</div>}
          {activeMenu === "Kategori Project" && <div>Kategori Project Content</div>}
          {activeMenu === "Piket" && <div>Piket Content</div>}
        </div>
      </div>

      {/* CSS untuk animasi bounce */}
      <style jsx>{`
        @keyframes bounceIn {
          0% {
            transform: translateY(20px);
            opacity: 0;
          }
          60% {
            transform: translateY(-5px);
          }
          100% {
            transform: translateY(0);
            opacity: 1;
          }
        }

        .animate-bounce-in {
          animation: bounceIn 0.5s ease-out;
        }
      `}</style>
    </>
  );
};

export default CompanyCard;
