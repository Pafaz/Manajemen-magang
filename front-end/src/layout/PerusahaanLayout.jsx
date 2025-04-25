import { Link, Outlet, useNavigate } from "react-router-dom";
import { useState, useEffect, useContext } from "react";
import { AuthContext } from "../contexts/AuthContext";
import NavAdmin from "../components/ui/NavAdmin";

const PerusahaanLayout = () => {
  const [openMenu, setOpenMenu] = useState(null);
  const { role, token } = useContext(AuthContext);
  const navigate = useNavigate();

  const sidebarMenus = [
    {
      icon: "bi-columns-gap",
      label: "Dashboard",
      link: "/perusahaan/dashboard",
    },
    {
      icon: "bi-bar-chart-steps",
      label: "Kelola Perusahaan",
      hasSubmenu: true,
      submenu: [
        {
          label: "Approval",
          link: "/perusahaan/approval",
        },
        {
          label: "Pendataan",
          link: "/perusahaan/pendataan",
        },
        {
          label: "Absensi",
          link: "/perusahaan/perusahaan/dokumen",
        },
        {
          label: "Surat Penerimaan",
          link: "/perusahaan/perusahaan/dokumen",
        },
        {
          label: "Surat Peringatan",
          link: "/perusahaan/perusahaan/dokumen",
        },
        {
          label: "Lembaga",
          link: "/perusahaan/perusahaan/dokumen",
        },
        {
          label: "RFID",
          link: "/perusahaan/perusahaan/dokumen",
        },
        {
          label: "Divisi",
          link: "/perusahaan/perusahaan/dokumen",
        },
        {
          label: "Project",
          link: "/perusahaan/perusahaan/dokumen",
        },
        {
          label: "Surat",
          link: "/perusahaan/surat",
        },
        {
          label: "Lembaga",
          link: "/perusahaan/lembaga",
        },
        {
          label: "RFID",
          link: "/perusahaan/perusahaan/dokumen",
        },
        {
          label: "Divisi",
          link: "/perusahaan/perusahaan/dokumen",
        },
        {
          label: "Project",
          link: "/perusahaan/perusahaan/dokumen",
        },
      ],
    },
    {
      icon: "bi-layers",
      label: "Kelola Cabang",
      link: "/perusahaan/lembaga",
    },
    {
      icon: "bi-grid-3x3-gap",
      label: "Kelola Lowongan",
    },
    {
      icon: "bi-gear",
      label: "Account Settings",
      link: "/perusahaan/settings",
    },
  ];
  const footerMenus = ["License", "More Themes", "Documentation", "Support"];

  useEffect(() => {
    if ((role && role !== "perusahaan") || !token) {
      const redirectTo = localStorage.getItem("loaction");
      if (redirectTo) {
        navigate(redirectTo);
        localStorage.removeItem("location");
      } else {
        navigate("/");
      }
    }
  }, [role]);

  return (
    <div className="w-full flex">
      <div className="bg-white border-r border-r-slate-300 w-[238px] h-screen fixed py-4 px-2 z-[50] overflow-y-auto">
        <Link to={`/`}>
          <img
            src="/assets/img/Logo.png"
            alt="Logo"
            className="w-48 mx-auto object-cover"
          />
        </Link>
        <div className="flex flex-col gap-3 mt-8">
          {sidebarMenus.map((menu, idx) => (
            <div key={idx} className="flex flex-col">
              {menu.hasSubmenu ? (
                <>
                  <button
                    onClick={() =>
                      setOpenMenu(openMenu === menu.label ? null : menu.label)
                    }
                    className={`px-4 py-2 rounded-lg flex gap-3 text-xs items-center justify-between text-slate-500 hover:text-white hover:bg-sky-800 transition-all duration-300`}
                  >
                    <div className="flex gap-3 items-center">
                      <i className={`bi ${menu.icon} text-lg`}></i>
                      <span className="font-light text-sm">{menu.label}</span>
                    </div>
                    <i
                      className={`bi bi-chevron-${
                        openMenu === menu.label ? "up" : "down"
                      } text-xs`}
                    ></i>
                  </button>
                  {openMenu === menu.label && (
                    <div className="ml-8 mt-1 flex flex-col gap-2">
                      {menu.submenu.map((sub, subIdx) => (
                        <Link
                          key={subIdx}
                          to={sub.link}
                          className="text-sm text-slate-600 hover:text-white hover:bg-sky-600 px-3 py-1 rounded transition-all duration-300"
                        >
                          {sub.label}
                        </Link>
                      ))}
                    </div>
                  )}
                </>
              ) : (
                <Link
                  to={menu.link}
                  className="px-4 py-2 rounded-lg flex gap-3 items-center text-slate-500 hover:text-white hover:bg-sky-800 transition-all duration-500 ease-in-out"
                >
                  <i className={`bi ${menu.icon} text-lg`}></i>
                  <span className="font-light text-sm">{menu.label}</span>
                </Link>
              )}
            </div>
          ))}
        </div>
      </div>

      <div className="flex-1 ml-[238px] min-h-screen overflow-y-hidden">
        <NavAdmin />
        {/* Page Content */}
        <div className="pt-5 px-3 bg-indigo-50 min-h-screen overflow-">
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

export default PerusahaanLayout;
