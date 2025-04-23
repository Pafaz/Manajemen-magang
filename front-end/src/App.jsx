import AuthProvider from "../context/AuthProvider";
import { RouterProvider } from "react-router-dom";
import { router } from "../Router";
import CustomCursor from "./components/CustomCursor";
function App() {
  return (
    <AuthProvider>
      <div className="relative">
        <CustomCursor />
      </div>
      <RouterProvider router={router} />
    </AuthProvider>
  );
}

export default App;
