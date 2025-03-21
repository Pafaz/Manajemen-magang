import NavLink from "./NavbarLink";

const Navbar = () => {
  const router_link = [
    { link: "/", name: "Home",active:true },
    { link: "/about_us", name: "About us" },
    { link: "/gallery", name: "Gallery" },
    { link: "/procedure", name: "Procedure" },
    { link: "/contact_us", name: "Contact us" },
  ];

  return (
    <nav className="bg-white w-full fixed z-50 py-5 px-10 flex justify-between">
      <div className="">
        <img src="assets/img/Logo.png" alt="Logo" className="w-52" />
      </div>
      <div className="flex gap-7 items-center">
        {router_link.map((item, index) => (
          <NavLink link={item.link} name={item.name} key={index + 1} active={item.active}/>
        ))}
        <button className="bg-[#0069AB] text-white text-sm py-2 px-8 block rounded-lg cursor-pointer">
          Login <i class="bi bi-arrow-right"></i>
        </button>
      </div>
    </nav>
  );
};

export default Navbar;
