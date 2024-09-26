import { router, usePage } from "@inertiajs/react";
import { useEffect } from "react";
import Layout from "../Layouts/Layout";
import { doctors } from "../utils/data";
import DoctorCard from "../components/DoctorCard";

function Home({ sidebarExpanded }) {
    const { auth, doctors } = usePage().props;

    // useEffect(() => {
    //     console.log(auth, doctors);
    // }, [auth]);

    return (
        <div className="w-full">
            <div
                className={`max-w-full grid grid-cols-1 sm:grid-cols-2 ${
                    sidebarExpanded
                        ? "md:grid-cols-1 xl:grid-cols-3"
                        : "xl:grid-cols-4"
                } place-content-center gap-8 mt-6`}
            >
                {doctors.map((doctor) => (
                    <DoctorCard doctor={doctor} key={doctor.id} />
                ))}
            </div>
        </div>
    );
}

// Home.layout = (page) => <Layout children={page} />;

export default Home;
