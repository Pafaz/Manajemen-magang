import PropTypes from "prop-types";
const Button = ({color,icon,size_rounded,children}) => {
  return (
    <div className={`${!color ? `border border-${color}-400/[0.8] bg-white text-${color}` : "bg-[#0069AB] text-white"} hover:bg-${color}-200 ${!size_rounded ? "rounded" : `rounded-${size_rounded}`} px-6 py-3 mt-6 ${icon ? "flex items-center gap-2 justify-center" : ""} text-center cursor-pointer`}>
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