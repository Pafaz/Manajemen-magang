import { Outlet } from "react-router-dom";
import Navbar from "../components/Navbar";

const GuestLayout = () => {
  return (
    <>
      <Navbar />
      <Outlet />
    </>
  );
};

export default GuestLayout;
