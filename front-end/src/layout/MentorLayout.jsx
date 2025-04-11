import { Link, Outlet } from "react-router-dom";
import { useState, useEffect } from "react";

const MentorLayout = () => {
  const [isDropdownOpen, setIsDropdownOpen] = useState(false);
  const [isRinging, setIsRinging] = useState(false);
  const [isPresentasiOpen, setIsPresentasiOpen] = useState(false);

  const sidebarMenus = [
    { icon: "bi-grid", label: "Dashboard", link: "/mentor/dashboard" },
    {
      icon: "bi-calendar4-week",
      label: "Presentasi",
      link: "/mentor/online",
      
    },
    {
      icon: "bi-clipboard2-minus",
      label: "Siswa",
      link: "/mentor/siswa",
    },
    {
      icon: "bi-mortarboard",
      label: "Track Record",
      link: "/mentor/track",
    },
    {
      icon: "bi-gear",
      label: "Account Settings",
      link: "/settings",
    },
  ];

  const footerMenus = ["License", "More Themes", "Documentation", "Support"];

  useEffect(() => {
    const interval = setInterval(() => {
      setIsRinging(true);
      setTimeout(() => setIsRinging(false), 800);
    }, 3000);
    return () => clearInterval(interval);
  }, []);

  useEffect(() => {
    const handleClickOutside = (event) => {
      if (!event.target.closest(".profile-dropdown")) {
        setIsDropdownOpen(false);
      }
    };
    document.addEventListener("click", handleClickOutside);
    return () => document.removeEventListener("click", handleClickOutside);
  }, []);

  return (
    <div className="w-full flex">
      {/* Sidebar */}
      <div className="bg-white border-r border-r-slate-300 w-[238px] h-screen fixed py-4 px-2 z-[60]">
        <img
          src="/assets/img/Logo.png"
          alt="Logo"
          className="w-48 mx-auto object-cover"
        />
        <div className="flex flex-col gap-3 mt-8">
          {sidebarMenus.map((menu, idx) => {
            if (menu.hasSubmenu) {
              return (
                <div key={idx} className="flex flex-col">
                  <button
                    onClick={() => setIsPresentasiOpen(!isPresentasiOpen)}
                    className="px-4 py-2 rounded-lg flex gap-3 items-center text-slate-500 hover:text-white hover:bg-sky-800 transition-all duration-500 ease-in-out"
                  >
                    <i className={`bi ${menu.icon} text-lg`}></i>
                    <span className="font-light text-sm">{menu.label}</span>
                  </button>
                </div>
              );
            }

            return (
              <Link
                to={menu.link}
                key={idx}
                className="px-4 py-2 rounded-lg flex gap-3 items-center text-slate-500 hover:text-white hover:bg-sky-800 transition-all duration-500 ease-in-out"
              >
                <i className={`bi ${menu.icon} text-lg`}></i>
                <span className="font-light text-sm">{menu.label}</span>
              </Link>
            );
          })}
        </div>
      </div>

      {/* Main Content */}
      <div className="flex-1 ml-[238px] min-h-screen">
        {/* Navbar */}
        <nav className="bg-white w-full h-[60px] flex items-center px-10 sticky top-0 z-50 border-b border-b-slate-300">
          <div className="flex gap-5 ml-auto items-center">
            <div className="w-7 h-7 rounded-full bg-indigo-100 relative flex justify-center items-center">
              <div className="bg-red-500 w-2 h-2 rounded-full absolute top-1 right-2 animate-ping"></div>
              <i className={`bi bi-bell ${isRinging ? "bell-shake" : ""}`}></i>
            </div>
            <div className="w-7 h-7 rounded-full bg-indigo-100 relative flex justify-center items-center">
              <i className="bi bi-globe text-sm"></i>
            </div>

            {/* Profile Dropdown */}
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
                <div className="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden">
                  <div className="py-2">
                    <a
                      href="#"
                      className="block px-4 py-2 text-gray-700 hover:bg-gray-100"
                    >
                      Menu 1
                    </a>
                    <a
                      href="#"
                      className="block px-4 py-2 text-gray-700 hover:bg-gray-100"
                    >
                      Menu 2
                    </a>
                  </div>
                </div>
              )}
            </div>
          </div>
        </nav>

        {/* Page Content */}
        <div className="pt-5 px-3 bg-indigo-50 min-h-screen overflow-y-auto">
          <Outlet />
          <div className="mt-3">
            <div className="bg-white rounded-t-xl px-5 py-4 w-full flex justify-between">
              <div className="text-slate-400 font-normal text-sm">
                © Copyright Edmate 2024, All Right Reserved
              </div>
              <div className="flex gap-5">
                {footerMenus.map((item, i) => (
                  <Link
                    key={i}
                    to="#"
                    className="text-slate-400 text-sm font-normal"
                  >
                    {item}
                  </Link>
                ))}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default MentorLayout;
