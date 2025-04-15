import { Link } from "react-router-dom";
import FloatingLabelInput from "../../components/FloatingLabelInput";

const Login = () => {
  return (
    <div className="w-full h-screen bg-white relative px-20 py-10 overflow-hidden">
      <div className="flex justify-start">
        <img src="/assets/img/Logo.png" alt="Logo" className="w-52" />
      </div>
      <div className="absolute right-0 top-0 z-10">
        <img src="/assets/Auth/ShapeRight.png" alt="ShapeRight" />
      </div>
      <div className="absolute right-0 top-30 z-20">
        <img
          src="/assets/Auth/ilustrationRight.png"
          alt="ilustrationRight"
          className="w-xl"
        />
      </div>
      <div className="w-full max-w-sm absolute z-50 left-35 top-45">
        <div className="space-y-5">
          <h1 className="text-3xl font-bold text-gray-800">Welcome to Back! 👋</h1>
          <p className="text-gray-500 text-sm mb-5">
          Please sign in to your account and start the adventure
          </p>
        </div>
        <FloatingLabelInput label="Email" type="email" className="mt-4" icon="bi-person" placeholder="Type Your Email"/>
        <FloatingLabelInput label="Password" type="password" className="mt-4" icon="bi-lock" placeholder="Password"/>
        <div className="flex items-center justify-between mt-2">
          <div>
            <input type="checkbox" id="terms" className="mr-2" />
            <label htmlFor="terms" className="text-sm text-gray-700">
              Remember Me
            </label>
          </div>
          <Link className="text-sm font-medium text-sky-500">
            Forgot Password ?
          </Link>
        </div>
        <button className="w-full mt-4 p-3 bg-blue-500 text-white rounded-full font-bold hover:bg-blue-600">
          Login
        </button>
        <div className="text-center py-5">
          <h1 className="font-medium text-slate-800 text-sm">
            Don’t have an account?{" "}
            <Link to={`/auth/register`} className="text-sky-500 font-semibold">
            Create an account
            </Link>
          </h1>
        </div>
        <div className="flex items-center my-4">
          <div className="flex-1 border-t border-gray-300"></div>
          <p className="mx-4 text-gray-500">Or login with</p>
          <div className="flex-1 border-t border-gray-300"></div>
        </div>

        <div className="">
          <button className="w-full border border-blue-500 py-2.5 rounded-sm hover:bg-sky-50 hover:border-blue-500 cursor-pointer hover:scale-105 transition-all duration-300 ease-in-out flex gap-2 justify-center">
            <img
              src="/assets/Auth/Google.png"
              alt="Facebook"
              className="w-6 h-6"
            />
            {/* <span className="font-light text-gray-900">Google</span> */}
          </button>
        </div>
      </div>
    </div>
  );
};

export default Login;
