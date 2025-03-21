import { createBrowserRouter } from "react-router-dom";
import GuestLayout from "./src/layout/GuestLayout";
import Index from "./src/pages/Index";
import NotFound from "./src/pages/Error/NotFound";

export const router = createBrowserRouter([
  {
    path: "/",
    element: <GuestLayout />,
    children: [
      {
        path: "/",
        element: <Index />,
      },
    ],
  },
   {
      path: "*",
      element: <NotFound />,
    },
]);
