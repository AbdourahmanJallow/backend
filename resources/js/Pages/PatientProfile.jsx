import { useForm, usePage } from "@inertiajs/react";
import { useEffect } from "react";
import axios from "axios";
import AppointmentsGrid from "../components/AppointmentsGrid";
import toast from "react-hot-toast";
import { Inertia } from "@inertiajs/inertia";

function PatientProfile() {
    const { user, appointments } = usePage().props;

    // useEffect(() => {
    //     console.log(user, appointments);
    // }, []);

    const placeholderImage = "/assets/profile.jpg";

    const { data, setData, put, processing, errors, progress, reset } = useForm(
        {
            name: user.name || "",
            email: user.email || "",
            address: user.patient.address || "",
            dateOfBirth: user.dateOfBirth || "",
            avatar: null,
        }
    );

    const handleSubmit = (e) => {
        e.preventDefault();
        // const formData = new FormData();
        // formData.append("name", data.name);
        // formData.append("email", data.email);
        // formData.append("address", data.address);
        // formData.append("dateOfBirth", data.dateOfBirth);

        // if (data.avatar) {
        //     formData.append("avatar", data.avatar);
        // }

        try {
            console.log("submitting");
            put("/patient/updateProfile", {
                // _method: "put",
                preserveScroll: true,
                onSuccess: () => {
                    // console.log("On Success", data);
                    reset();
                    Inertia.reload({ only: ["user"] });
                },
                onError: (errors) => {
                    console.log("On Error", errors);
                },
            });
            toast.success("Profile updated successfully!");
        } catch (error) {
            console.log(error.message);
            toast.success("Profile failed to update!");
        }

        // try {
        //     axios
        //         .put("/patient/updateProfile", formData, {
        //             headers: {
        //                 "Content-Type": "multipart/form-data",
        //             },
        //         })
        //         .then((response) => {
        //             console.log("On Success", response.data);
        //         })
        //         .catch((error) => {
        //             console.log("On Error", error.response.data);
        //         });
        // } catch (error) {
        //     console.log(error);
        // }
    };

    const handleChange = (e) => {
        if (e.target.type === "file") {
            if (e.target.files && e.target.files.length >= 1) {
                const file = e.target.files[0];
                setData((prevData) => ({ ...prevData, avatar: file }));
            }
        } else {
            setData((prevData) => ({
                ...prevData,
                [e.target.id]: e.target.value,
            }));
        }
    };

    return (
        <div className="h-screen p-5 rounded flex flex-col justify-start items-start">
            <div className="w-full flex-col flex md:flex-row justify-start gap-8 items-center">
                <img
                    src={user?.avatar ? user?.avatar : placeholderImage}
                    alt="Patient Profile"
                    width={300}
                    className="rounded-full object-contain"
                />
                <div>
                    <h1 className="text-4xl font-bold">{user.name}</h1>
                    <h4 className="text-sm mt-2 text-slate-500">
                        {user.email}
                    </h4>
                </div>
            </div>

            <form
                encType="multipart/form-data"
                onSubmit={handleSubmit}
                className="mt-8 w-full"
            >
                <div className="flex flex-wrap gap-4">
                    <div className="w-full flex flex-col sm:flex-row gap-4">
                        <div className="w-full md:w-1/2">
                            <label
                                className="block text-gray-700 text-sm font-bold mb-2"
                                htmlFor="name"
                            >
                                Name
                            </label>
                            <input
                                id="name"
                                type="text"
                                value={data.name}
                                onChange={handleChange}
                                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            />
                            {errors.name && (
                                <p className="text-red-500 text-xs italic">
                                    {errors.name}
                                </p>
                            )}
                        </div>

                        <div className="w-full md:w-1/2">
                            <label
                                className="block text-gray-700 text-sm font-bold mb-2"
                                htmlFor="email"
                            >
                                Email
                            </label>
                            <input
                                id="email"
                                type="email"
                                value={data.email}
                                onChange={handleChange}
                                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            />
                            {errors.email && (
                                <p className="text-red-500 text-xs italic">
                                    {errors.email}
                                </p>
                            )}
                        </div>
                    </div>

                    <div className="w-full flex flex-col sm:flex-row gap-4">
                        <div className="w-full md:w-1/2">
                            <label
                                className="block text-gray-700 text-sm font-bold mb-2"
                                htmlFor="address"
                            >
                                Address
                            </label>
                            <input
                                id="address"
                                type="text"
                                value={data.address}
                                onChange={handleChange}
                                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            />
                            {errors.address && (
                                <p className="text-red-500 text-xs italic">
                                    {errors.address}
                                </p>
                            )}
                        </div>

                        <div className="w-full md:w-1/2">
                            <label
                                className="block text-gray-700 text-sm font-bold mb-2"
                                htmlFor="dateOfBirth"
                            >
                                Date of Birth
                            </label>
                            <input
                                id="dateOfBirth"
                                type="date"
                                value={data.dateOfBirth}
                                onChange={handleChange}
                                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            />
                            {errors.dateOfBirth && (
                                <p className="text-red-500 text-xs italic">
                                    {errors.dateOfBirth}
                                </p>
                            )}
                        </div>
                    </div>

                    <div className="w-full md:w-1/2">
                        <label
                            className="block text-gray-700 text-sm font-bold mb-2"
                            htmlFor="avatar"
                        >
                            Profile Image
                        </label>
                        <input
                            id="avatar"
                            type="file"
                            onChange={handleChange}
                            className="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                        />
                        {errors.avatar && (
                            <p className="text-red-500 text-xs italic">
                                {errors.avatar}
                            </p>
                        )}
                    </div>
                </div>

                <div className="mt-6 flex items-center justify-between">
                    <button
                        type="submit"
                        className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        disabled={processing}
                    >
                        {processing ? "Updating..." : "Update Profile"}
                    </button>
                </div>
                {progress && (
                    <progress value={progress.percentage} max="100">
                        {progress.percentage}%
                    </progress>
                )}
            </form>

            <AppointmentsGrid appointments={appointments} />
        </div>
    );
}

// PatientProfile.layout = (page) => <Layout children={page} />;

export default PatientProfile;
