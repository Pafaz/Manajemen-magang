import PropTypes from "prop-types";
import { Link } from "react-router-dom";

const NavbarLink = ({ link, name, active }) => {
  return <Link to={link} className={`font-medium text-sm no-underline text-[#0069AB] hover:border-b border-b-blue-500 ${active ? "bg-[#0069AB] rounded-full px-7 text-white py-3 text-sm" : "no-underline"}`} style={{ textDecoration: "none" }}>{name}</Link>;
};

NavbarLink.propTypes = {
  link: PropTypes.string.isRequired,
  name: PropTypes.string.isRequired,
  active: PropTypes.bool.isRequired,
};

export default NavbarLink;
