import { useState } from "react";

const FloatingLabelInput = ({ label, type,ForName }) => {
  const [value, setValue] = useState("");

  return (
    <div className="relative w-full">
      <input
        type={type}
        id={ForName}
        value={value}
        onChange={(e) => setValue(e.target.value)}
        className="w-full bg-white rounded-lg border border-slate-300/[0.8] py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 peer mb-4"
        placeholder=" "
      />
      <label
        htmlFor={ForName}
        className={`absolute left-4 top-2 text-gray-500 transition-all transform bg-white px-1 
              peer-placeholder-shown:top-2 peer-placeholder-shown:text-base 
              peer-focus:-top-3 peer-focus:text-sm peer-focus:text-blue-500`}
      >
        {label}
      </label>
    </div>
  );
};

export default FloatingLabelInput;
