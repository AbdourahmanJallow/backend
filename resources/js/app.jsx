import "./bootstrap";
import "../css/app.css";

import { createInertiaApp } from "@inertiajs/react";
import { createRoot } from "react-dom/client";

import axios from "axios";
import Layout from "./Layouts/Layout";
import PrivateRoute from "./components/Auth/PrivateRoute";

// axios.defaults.withCredentials = true;

// // Get CSRF token from the backend
// axios.get("/sanctum/csrf-cookie").then(() => {
//     console.log("CSRF token set");
// });

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.jsx", { eager: true });
        let page = pages[`./Pages/${name}.jsx`];
        page.default.layout =
            page.default.layout ||
            ((page) => (
                <PrivateRoute>
                    <Layout children={page} />
                </PrivateRoute>
            ));
        return page;
    },
    setup({ el, App, props }) {
        createRoot(el).render(<App {...props} />);
    },
});
