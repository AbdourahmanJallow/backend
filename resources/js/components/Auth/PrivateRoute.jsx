import { router, usePage } from "@inertiajs/react";
import { useEffect, useState } from "react";

function PrivateRoute({ children }) {
    const auth = usePage().props.auth;
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        if (auth.user) {
            setLoading(false);
        } else {
            router.visit("/login-patient");
        }
        // console.log("Auth successful", auth);
    }, [auth]);

    if (loading) {
        return <div>Loading...</div>; // Show loading until auth is loaded
    }

    return <>{children}</>;
}

export default PrivateRoute;
