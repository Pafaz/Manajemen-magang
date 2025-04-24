import { useState, useEffect } from "react";
import axios from "axios";
import Modal from "../Modal";
import { Link } from "react-router-dom";

const NavAdmin = () => {
  const [isDropdownOpen, setIsDropdownOpen] = useState(false);
  const [isRinging, setIsRinging] = useState(false);
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [isLoggingOut, setIsLoggingOut] = useState(false);

  const handleLogout = async () => {
    setIsLoggingOut(true);
    try {
      const response = await axios.post(
        "http://127.0.0.1:8000/api/logout",
        {},
        {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
          },
        }
      );

      if (response.status === 200) {
        localStorage.removeItem("token");
        window.location.href = "/auth/login";
      } else {
        alert("Logout gagal, coba lagi.");
      }
    } catch (error) {
      console.error("Logout error:", error);
      alert("Terjadi kesalahan saat logout. Coba lagi.");
    } finally {
      setIsLoggingOut(false);
    }
  };

  useEffect(() => {
    const handleClickOutside = (event) => {
      if (!event.target.closest(".profile-dropdown")) {
        setIsDropdownOpen(false);
      }
    };
    document.addEventListener("click", handleClickOutside);
    return () => document.removeEventListener("click", handleClickOutside);
  }, []);

  useEffect(() => {
    const interval = setInterval(() => {
      setIsRinging(true);
      setTimeout(() => setIsRinging(false), 800);
    }, 3000);
    return () => clearInterval(interval);
  }, []);

  return (
    <nav className="bg-white w-full h-[60px] flex items-center px-10 sticky top-0 z-50 border-b border-b-slate-300">
      <div className="flex gap-5 ml-auto items-center">
        <div className="w-7 h-7 rounded-full bg-indigo-100 relative flex justify-center items-center">
          <div className="bg-red-500 w-2 h-2 rounded-full absolute top-1 right-2 animate-ping"></div>
          <i className={`bi bi-bell ${isRinging ? "bell-shake" : ""}`}></i>
        </div>
        <div className="w-7 h-7 rounded-full bg-indigo-100 relative flex justify-center items-center">
          <i className="bi bi-globe text-sm"></i>
        </div>

        <div className="relative profile-dropdown">
          <div
            className="flex items-center gap-2 bg-white pr-4 pl-1 py-0.5 rounded-full border border-gray-300 cursor-pointer"
            onClick={() => setIsDropdownOpen(!isDropdownOpen)}
          >
            <img
              src="/assets/img/user-img.png"
              alt="Profile"
              className="w-8 h-8 rounded-full object-cover"
            />
            <div className="absolute w-3 h-3 bg-green-500 rounded-full left-6 top-6 border-2 border-white"></div>
            <i className="bi bi-chevron-down text-gray-500"></i>
          </div>

          {isDropdownOpen && (
            <div className="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden z-50">
              <div className="py-2">
                <Link
                  to={"/perusahaan/settings"}
                  className="block px-4 py-2 text-gray-700 hover:bg-gray-100"
                >
                  Settings
                </Link>
                <a
                  href="#"
                  className="block px-4 py-2 text-gray-700 hover:bg-gray-100"
                  onClick={() => setIsModalOpen(true)}
                >
                  Logout
                </a>
              </div>
            </div>
          )}
        </div>
      </div>

      <Modal
        isOpen={isModalOpen}
        onClose={() => setIsModalOpen(false)}
        title="Logout Confirmation"
      >
        <div className="flex justify-center items-center gap-4">
          <button
            onClick={handleLogout}
            className="px-4 py-1.5 text-sm hover:bg-rose-400 bg-red-600 text-white rounded-lg"
          >
            {isLoggingOut ? "Logging out..." : "Yes, Logout"}
          </button>
          <button
            onClick={() => setIsModalOpen(false)}
            className="px-4 py-1.5 text-sm bg-gray-300 hover:bg-gray-200 text-gray-800 rounded-lg"
          >
            Cancel
          </button>
        </div>
      </Modal>
    </nav>
  );
};

export default NavAdmin;
