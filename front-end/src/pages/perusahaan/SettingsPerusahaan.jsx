import { useState } from "react";
import DataPerusahaan from "../../components/cards/DataPerusahaan";
import Password from "../../components/cards/Password";
import ModalTambahAdminCabang from "../../components/modal/ModalTambahAdminCabang";
import ModalDeleteAdminCabang from "../../components/modal/ModalDeleteAdminCabang";

const CompanyCard = () => {
  const [companyName] = useState("PT. HUMMA TECHNOLOGY INDONESIA");
  const [description] = useState("Perusahaan ini bergerak di bidang Informasi dan Teknologi untuk perkembangan Industri");
  const [location] = useState("Malang, Indonesia");
  const [contactPerson] = useState("Afrizal Hilmawan");

  const [branchName, setBranchName] = useState("");
  const [businessField, setBusinessField] = useState("");
  const [address, setAddress] = useState("");
  const [charCount, setCharCount] = useState(0);
  const [websiteUrl, setWebsiteUrl] = useState("");
  const [instagramUrl, setInstagramUrl] = useState("");
  const [linkedinUrl, setLinkedinUrl] = useState("");

  const [showAddModal, setShowAddModal] = useState(false);
  const [showDeleteModal, setShowDeleteModal] = useState(false);
  const [branchToDelete, setBranchToDelete] = useState(null);

  const [animating, setAnimating] = useState(false);
  const [activeMenu, setActiveMenu] = useState("Data Perusahaan");

  const handleAddressChange = (e) => {
    const text = e.target.value;
    setAddress(text);
    setCharCount(text.length);
  };

  const handleMenuClick = (menuName) => {
    if (menuName !== activeMenu) {
      setAnimating(true);
      setTimeout(() => {
        setActiveMenu(menuName);
        setTimeout(() => {
          setAnimating(false);
        }, 50);
      }, 300);
    }
  };

  const handleAddAdminClick = () => {
    setShowAddModal(true);
  };

  const handleAddAdmin = (adminData) => {
    setShowAddModal(false);
  };

  const handleDeleteAdminClick = (branch) => {
    setBranchToDelete(branch);
    setShowDeleteModal(true);
  };

  const handleDeleteAdmin = () => {
    setShowDeleteModal(false);
    setBranchToDelete(null);
  };

  const menuItems = [
    { label: "Data Perusahaan" },
    { label: "Password" }
  ];

  return (
    <>
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

        <div className="flex gap-1 mt-2 mb-0 px-6">
          {menuItems.map((menu, index) => (
            <div
              key={index}
              className={`px-3 py-1.5 cursor-pointer rounded-t-lg transition-all duration-300 ease-in-out ${
                activeMenu === menu.label ? "bg-[#ECF2FE] text-[#0069AB] font-medium transform scale-105" : "bg-white-100 text-black-600 hover:bg-[#ECF2FE] hover:text-[#0069AB]"
              }`}
              onClick={() => handleMenuClick(menu.label)}
            >
              <span className="text-[13px] font-medium relative">
                {menu.label}
                {activeMenu === menu.label && <span className="absolute bottom-0 left-0 w-full h-0.5 bg-[#0069AB] rounded-full"></span>}
              </span>
            </div>
          ))}
        </div>
      </div>

      <div className="bg-[#ECF2FE] pt-4 pb-4 overflow-hidden">
        <div className={`transition-all duration-300 ease-in-out transform ${animating ? "opacity-0 translate-y-8" : "opacity-100 translate-y-0 animate-bounce-in"}`}>
          {activeMenu === "Data Perusahaan" && <DataPerusahaan />}
          {activeMenu === "Password" && <Password />}
        </div>
      </div>

      <ModalTambahAdminCabang 
        isOpen={showAddModal}
        onClose={() => setShowAddModal(false)}
        onSave={handleAddAdmin}
      />

      <ModalDeleteAdminCabang 
        isOpen={showDeleteModal}
        onClose={() => setShowDeleteModal(false)}
        onConfirm={handleDeleteAdmin}
      />

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
