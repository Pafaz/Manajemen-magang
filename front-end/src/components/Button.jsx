import PropTypes from "prop-types";
const Button = ({color,icon,children}) => {
  return (
    <div className={`py-3 px-5 text-white bg-[#0069AB] hover:bg-[#355467] cursor-pointer font-medium rounded-sm text-xs transition duration-300 ease-in-out text-center ${icon ? "flex justify-center gap-5 mt-6 items-center" : ""}`}>
        {children}
        {icon && (
        <i className={`bi ${icon} text-${color} text-sm font-semibold`}></i>
        )}
    </div>
  )
}

Button.propTypes = {
    color:PropTypes.string.isRequired,
    children:PropTypes.node.isRequired,
    icon:PropTypes.string.isRequired,
    size_rounded:PropTypes.string,
}

export default Button