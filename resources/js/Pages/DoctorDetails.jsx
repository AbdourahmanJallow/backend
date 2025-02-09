import { Link, router, useForm, usePage } from "@inertiajs/react";
import { ArrowLeftIcon, X } from "lucide-react";
import { useRef, useState, useEffect } from "react";
import { toast } from "react-hot-toast";

function DoctorDetails() {
    const { doctor } = usePage().props;

    const { data, setData, post, errors, reset } = useForm({
        date: new Date().toISOString().slice(0, 10), // Set today's date
        time: new Date().toTimeString().slice(0, 5),
        reasons: "",
        doctor_id: doctor.id,
    });

    const [appointment, setAppointement] = useState(false);

    const dialogRef = useRef();

    useEffect(() => {
        if (!appointment) return;

        dialogRef.current?.showModal();
    }, [appointment]);

    const closeModal = () => {
        dialogRef.current?.close();
        setAppointement(false);
    };

    const handleChange = (e) => {
        setData({ ...data, [e.target.id]: e.target.value });
    };

    // const handleSubmit = (e) => {
    //     e.preventDefault();

    //     setAppointement(true);

    //     // try {
    //     //     post("/patientsAppointments", data, {
    //     //         onSuccess: () => {
    //     //             reset();
    //     //         },
    //     //         onError: (errors) => {
    //     //             console.log(errors);
    //     //             toast.error("Oops. Appointment Failed!");
    //     //         },
    //     //     });
    //     //     reset();
    //     //     toast.success("Appointment made successfully!");
    //     // } catch (error) {
    //     //     console.log(error.message);
    //     //     toast.error("Appointment Failed!");
    //     // }
    // };

    const confirmBooking = () => {
        try {
            post("/patientsAppointments", data, {
                onSuccess: () => {
                    reset();
                },
                onError: (errors) => {
                    console.log(errors);
                    toast.error("Oops. Appointment Failed :(");
                },
            });
            reset();
            toast.success("Appointment made successfully :)", {
                duration: 5000,
            });
        } catch (error) {
            console.log(error.message);
            toast.error("Appointment Failed!");
        } finally {
            closeModal();
        }
    };

    return (
        <div className="w-full min-h-screen p-6 shadow-m rounded-md">
            <dialog
                ref={dialogRef}
                className="rounded backdrop:bg-black/85 relative overflow-visible px-4 py-2"
            >
                {appointment && (
                    <div className="max-w-[90vw] sm:w-96 max-h-[90vh] rounded flex flex-col justify-between items-center text-wrap">
                        <div>
                            <h4 className="font-semibold text-2xl pt-4">
                                Appointment Details
                            </h4>
                            <p className="text tracking-wide italic mt-6">
                                Confirm appointment with {doctor.user.name} on{" "}
                                <span className="font-bold text-blue-500">
                                    {new Date(data.date)
                                        .toISOString()
                                        .slice(0, 10)}{" "}
                                </span>
                                at{" "}
                                <span className="text-blue-500">
                                    {data.time}
                                </span>
                                .
                            </p>
                            <p className="mt-2">
                                <span className="font-bold">For </span>
                                {data.reasons}
                            </p>
                        </div>
                        <button
                            className="absolute -top-2 -right-2 w-5 h-5 rounded-full bg-zinc-200 text-white flex justify-center items-center cursor-pointer"
                            onClick={closeModal}
                        >
                            <X className="w-4 h-4 text-zinc-900" />
                            <span className="sr-only">Close</span>
                        </button>

                        {/* confirm button */}
                        <button
                            onClick={confirmBooking}
                            className="w-full mt-4 bg-lime-600 hover:bg-lime-700 text-white rounded-lg p-3"
                        >
                            confirm
                        </button>
                    </div>
                )}
            </dialog>
            <div className="container mx-auto">
                <Link href={"/doctors"} className="p-2">
                    <ArrowLeftIcon />
                </Link>
                {/* Doctor Details Row */}
                <div className="flex flex-col md:flex-row items-start gap-8 h-screen">
                    {/* Doctor Image */}
                    <div className="md:w-1/2 w-full h-full">
                        <img
                            // src="https://hips.hearstapps.com/hmg-prod/images/portrait-of-a-happy-young-doctor-in-his-clinic-royalty-free-image-1661432441.jpg"
                            src={`${
                                doctor?.user?.avatar ??
                                "https://hips.hearstapps.com/hmg-prod/images/portrait-of-a-happy-young-doctor-in-his-clinic-royalty-free-image-1661432441.jpg"
                            }`}
                            alt={doctor.user.name}
                            className="w-full h-full object-cover rounded-lg"
                        />
                    </div>

                    {/* Doctor Details */}
                    <div className="md:w-1/2 w-full flex flex-col justify-between">
                        <div>
                            <h1 className="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                                Dr. {doctor.user.name}
                            </h1>
                            <p className="text-lg font-semibold text-gray-600">
                                Specialization: {doctor.specialization}
                            </p>
                            <p className="text-lg text-gray-600">
                                {doctor.yearsOfExperience} years of experience
                            </p>
                            <p className="text-base text-gray-700 mt-4">
                                {doctor.bio}
                            </p>
                            <p className="text-base text-gray-700 mt-4">
                                <span className="text-lg font-bold">
                                    Location:
                                </span>{" "}
                                {doctor.clinicalAddress}
                            </p>
                            <p className="text-base text-gray-700 mt-1">
                                <span className="text-lg font-bold">
                                    Contact:
                                </span>{" "}
                                {doctor.user.email}
                            </p>
                        </div>

                        {/* Appointment form */}
                        <div className="w-full mt-24 mx-auto">
                            <form
                                onSubmit={(e) => {
                                    e.preventDefault();
                                    setAppointement(true);
                                }}
                                className="bg-neutral-100 p-6 rounded-lg shadow-lg"
                            >
                                <div className="mb-4">
                                    <label className="block text-sm font-medium text-gray-700">
                                        Reasons
                                    </label>
                                    <textarea
                                        type="text"
                                        name="reasons"
                                        id="reasons"
                                        rows="6"
                                        value={data.reasons}
                                        onChange={handleChange}
                                        required
                                        className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none"
                                    />
                                </div>
                                <div className="mb-4">
                                    <label className="block text-sm font-medium text-gray-700">
                                        Appointment Date
                                    </label>
                                    <input
                                        type="date"
                                        name="date"
                                        id="date"
                                        value={data.date}
                                        onChange={handleChange}
                                        required
                                        className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none"
                                    />
                                </div>

                                <div className="mb-4">
                                    <label className="block text-sm font-medium text-gray-700">
                                        Appointment Time
                                    </label>
                                    <input
                                        type="time"
                                        name="time"
                                        id="time"
                                        value={data.time}
                                        onChange={handleChange}
                                        required
                                        className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none"
                                    />
                                </div>

                                <button
                                    // onClick={}
                                    type="submit"
                                    className="w-full bg-lime-500 hover:bg-lime-600 text-white rounded-lg p-3"
                                >
                                    Request Appointment
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default DoctorDetails;
