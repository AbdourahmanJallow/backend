import { router, useForm, usePage } from "@inertiajs/react";
import { useEffect, useState } from "react";
import Layout from "../Layouts/Layout";
import { doctors } from "../utils/data";
import DoctorCard from "../components/DoctorCard";
import toast from "react-hot-toast";
import SearchInput from "../components/SearchInput";
import Pagination from "../components/Pagination";

function Doctors({ sidebarExpanded }) {
    const { auth, doctors } = usePage().props;
    const { data, setData, get } = useForm({
        search: "",
        page: doctors.current_page,
    });

    // useEffect(() => {
    // toast.success(`Welcome ${auth.user.name}`);
    // console.log(doctors);
    // get("/", { preserveState: true, search: data.search });
    // }, [data]);

    const handleSearch = (e) => {
        e.preventDefault();

        try {
            console.log(data.query);
            get("/doctors", {
                preserveState: true,
                search: data.search,
            });
        } catch (error) {
            console.log(error);
        }
    };

    return (
        <div className="min-h-screen w-full flex flex-col justify-between">
            <SearchInput
                data={data}
                setData={setData}
                onSubmit={handleSearch}
            />
            <div
                className={`max-w-full grid grid-cols-1 sm:grid-cols-2 ${
                    sidebarExpanded
                        ? "md:grid-cols-1 xl:grid-cols-3"
                        : "xl:grid-cols-4"
                } place-content-center gap-8 mt-6`}
            >
                {doctors.data.length > 0 ? (
                    doctors.data.map((doctor) => (
                        <DoctorCard doctor={doctor} key={doctor.id} />
                    ))
                ) : (
                    <p>No Doctors found :(</p>
                )}
            </div>

            {/* Pagination */}
            <Pagination
                links={doctors.links}
                currentPage={data.page}
                setCurrentPage={(page) => setData("page", page)}
            />
        </div>
    );
}

// Doctors.layout = (page) => <Layout children={page} />;

export default Doctors;
