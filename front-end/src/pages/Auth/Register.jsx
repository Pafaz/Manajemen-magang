import FloatingLabelInput from "../../components/FloatingLabelInput";

const Register = () => {
  return (
    <div className="w-full h-screen bg-white relative px-20 py-10 overflow-hidden">
      <div className="flex justify-end">
        <img src="/assets/img/Logo.png" alt="Logo" className="w-52" />
      </div>
      <div className="absolute left-0 top-0 z-10">
        <img src="/assets/Auth/Shape_blue.png" alt="ShapeBlue" />
      </div>
      <div className="absolute left-0 top-30 z-20">
        <img
          src="/assets/Auth/ilustrationAuth.png"
          alt="ilustrationAuth"
          className="w-xl"
        />
      </div>
      <div className="w-full max-w-xl absolute z-50 right-40 top-35">
        <div className="space-y-5">
          <h1 className="text-4xl font-bold text-gray-800">Sign Up</h1>
          <p className="text-gray-500 text-sm mb-5">
            Let’s get you all set up so you can access your personal account.
          </p>
        </div>
        <div className="grid grid-cols-2 gap-2">
          <FloatingLabelInput ForName={`FristName`} label="First Name" type="text" />
          <FloatingLabelInput ForName={`LastName`} label="Last Name" type="text" />
          <FloatingLabelInput ForName={`Email`} label="Email" type="email" className="mt-4" />
          <FloatingLabelInput ForName={`PhoneNumber`} label="Phone Number" type="text" className="mt-4"/>
        </div>
        <FloatingLabelInput ForName={`Password`} label="Password" type="password" className="mt-4" />
        <FloatingLabelInput ForName={`ConfirmPassword`} label="Confirm Password" type="password" className="mt-4"/>
        <div className="flex items-center mt-4">
          <input type="checkbox" id="terms" className="mr-2" />
          <label htmlFor="terms" className="text-sm text-gray-700">
            I agree to all the{" "}
            <span className="text-red-500 font-semibold">Terms</span> and
            <span className="text-red-500 font-semibold">
              {" "}
              Privacy Policies
            </span>
          </label>
        </div>
        <button className="w-full mt-4 p-3 bg-blue-500 text-white rounded-lg font-bold hover:bg-blue-600">
          Sign Up
        </button>
        <div className="flex items-center my-4">
          <div className="flex-1 border-t border-gray-300"></div>
          <p className="mx-4 text-gray-500">Or Sign Up</p>
          <div className="flex-1 border-t border-gray-300"></div>
        </div>

        <div className="flex justify-center gap-4">
          <button className="border border-blue-500 w-44 py-2.5 rounded-sm hover:bg-sky-50 hover:border-blue-500 cursor-pointer hover:scale-105 transition-all duration-300 ease-in-out">
            <img
              src="/assets/Auth/Facebook.png"
              alt="Facebook"
              className="w-6 h-6 mx-auto"
            />
          </button>
          <button className="border border-blue-500 w-44 py-2.5 rounded-sm hover:bg-sky-50 hover:border-blue-500 cursor-pointer hover:scale-105 transition-all duration-300 ease-in-out">
            <img
              src="/assets/Auth/Google.png"
              alt="Google"
              className="w-6 h-6 mx-auto"
            />
          </button>
          <button className="border border-blue-500 w-44 py-2.5 rounded-sm hover:bg-sky-50 hover:border-blue-500 cursor-pointer hover:scale-105 transition-all duration-300 ease-in-out">
            <img
              src="/assets/Auth/Apple.png"
              alt="Apple"
              className="w-6 h-6 mx-auto"
            />
          </button>
        </div>
      </div>
    </div>
  );
};

export default Register;
