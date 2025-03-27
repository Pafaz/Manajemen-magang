import { useState, useEffect } from "react";
import NavLink from "./NavbarLink";

const Navbar = () => {
  const [isScrolled, setIsScrolled] = useState(false);

  useEffect(() => {
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 50);
    };

    window.addEventListener("scroll", handleScroll);
    return () => window.removeEventListener("scroll", handleScroll);
  }, []);

  const router_link = [
    { link: "/", name: "Home", active: true },
    { link: "/about_us", name: "About us" },
    { link: "/gallery", name: "Gallery" },
    { link: "/procedure", name: "Procedure" },
    { link: "/contact_us", name: "Contact us" },
  ];

  return (
    <nav
      className={`fixed w-full z-[9999] px-10 flex justify-between items-center transition-all duration-300 ease-in-out ${
        isScrolled
          ? "bg-white/30 backdrop-blur-sm border-b border-gray-300/50 py-2.5"
          : "bg-white shadow-sm py-4"
      }`}
    >
      <div>
        <img
          src="assets/img/Logo.png"
          alt="Logo"
          className="w-48 transition-all duration-300"
        />
      </div>
      <div className="flex gap-7 items-center">
        {router_link.map((item, index) => (
          <NavLink
            link={item.link}
            name={item.name}
            key={index}
            active={item.active}
            className="relative text-gray-700 hover:text-[#0069AB] after:content-[''] after:block after:w-0 after:h-[2px] after:bg-[#0069AB] after:transition-all after:duration-300 hover:after:w-full"
          />
        ))}
        <button
          className="relative overflow-hidden bg-[#0069AB] text-white text-sm py-2 px-6 rounded-lg cursor-pointer transition-all duration-300 ease-in-out 
      hover:bg-gradient-to-r hover:from-[#005588] hover:to-[#619dc2] 
      hover:shadow-lg hover:scale-105 flex items-center gap-2 group"
        >
          Login
          <i className="bi bi-arrow-right transition-transform duration-300 group-hover:translate-x-1"></i>
        </button>
      </div>
    </nav>
  );
};

export default Navbar;
