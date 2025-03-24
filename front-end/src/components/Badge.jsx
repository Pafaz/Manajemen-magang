const Badge = ({ children }) => {
  return (
    <div className="bg-blue-100 py-1.5 px-4 w-1/5 border border-blue-400/[0.5] rounded-xl text-blue-500 text-center text-xs">
      {children}
    </div>
  );
};

export default Badge;
