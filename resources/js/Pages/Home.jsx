import { router, useForm, usePage } from "@inertiajs/react";
import { useEffect, useState } from "react";
import Layout from "../Layouts/Layout";
import { doctors } from "../utils/data";
import DoctorCard from "../components/DoctorCard";
import toast from "react-hot-toast";
import SearchInput from "../components/SearchInput";
import Pagination from "../components/Pagination";

import { Head, Link } from "@inertiajs/react";

export default function Home() {
    const [isMenuOpen, setIsMenuOpen] = useState(false);

    return (
        <>
            <Head title="Healthcare Assistant - Home" />

            {/* Hero Section */}
            <section classNam="bg-gradient-to-b from-lime-50 to-white">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-24">
                    <div className="text-center">
                        <h1 className="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                            <span className="block">Your Health is Our</span>
                            <span className="block text-lime-600 mt-6">
                                Top Priority
                            </span>
                        </h1>
                        <p className="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                            Access quick disease prediction and easy appointment
                            booking all in one place. Get the care you need,
                            when you need it.
                        </p>
                        <div className="mt-10 flex justify-center gap-4 flex-col sm:flex-row">
                            <Link
                                href="/doctors"
                                className="rounded-md px-8 py-3 bg-lime-600 text-white font-medium hover:bg-lime-700 transition duration-150 ease-in-out"
                            >
                                Book an Appointment
                            </Link>
                            <Link
                                href="/disease-predictor"
                                className="rounded-md px-8 py-3 bg-white text-lime-600 font-medium border border-lime-600 hover:bg-lime-50 transition duration-150 ease-in-out"
                            >
                                Check Symptoms
                            </Link>
                        </div>
                    </div>
                </div>
            </section>

            {/* Features Section */}
            <section className="py-16 bg-white">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="grid md:grid-cols-2 gap-8">
                        {/* Appointment Booking Feature */}
                        <div className="bg-lime-50 rounded-xl p-8 border border-lime-100">
                            <div className="w-12 h-12 bg-lime-100 rounded-lg flex items-center justify-center mb-4">
                                <svg
                                    className="w-6 h-6 text-lime-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                    />
                                </svg>
                            </div>
                            <h3 className="text-xl font-bold text-gray-900 mb-2">
                                Easy Appointment Booking
                            </h3>
                            <p className="text-gray-500 mb-4">
                                Schedule appointments with healthcare
                                professionals quickly and easily. Choose your
                                preferred time and date.
                            </p>
                            <Link
                                href="/appointments"
                                className="text-lime-600 font-medium hover:text-lime-700 inline-flex items-center"
                            >
                                Book Now
                                <svg
                                    className="w-4 h-4 ml-2"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M9 5l7 7-7 7"
                                    />
                                </svg>
                            </Link>
                        </div>

                        {/* Disease Prediction Feature */}
                        <div className="bg-lime-50 rounded-xl p-8 border border-lime-100">
                            <div className="w-12 h-12 bg-lime-100 rounded-lg flex items-center justify-center mb-4">
                                <svg
                                    className="w-6 h-6 text-lime-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
                                    />
                                </svg>
                            </div>
                            <h3 className="text-xl font-bold text-gray-900 mb-2">
                                Disease Prediction
                            </h3>
                            <p className="text-gray-500 mb-4">
                                Get instant preliminary assessment of your
                                symptoms using our advanced prediction model.
                                Quick and confidential.
                            </p>
                            <Link
                                href="/disease-predictor"
                                className="text-lime-600 font-medium hover:text-lime-700 inline-flex items-center"
                            >
                                Check Symptoms
                                <svg
                                    className="w-4 h-4 ml-2"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M9 5l7 7-7 7"
                                    />
                                </svg>
                            </Link>
                        </div>
                    </div>
                </div>
            </section>

            {/* Benefits Section */}
            <section className="py-16 bg-lime-50">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 className="text-3xl font-bold text-center text-gray-900 mb-12">
                        Why Choose Us
                    </h2>
                    <div className="grid md:grid-cols-3 gap-8">
                        {/* Benefit 1 */}
                        <div className="text-center">
                            <div className="w-12 h-12 bg-lime-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg
                                    className="w-6 h-6 text-lime-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M13 10V3L4 14h7v7l9-11h-7z"
                                    />
                                </svg>
                            </div>
                            <h3 className="text-lg font-semibold text-gray-900 mb-2">
                                Quick Response
                            </h3>
                            <p className="text-gray-500">
                                Get instant predictions and book appointments in
                                minutes
                            </p>
                        </div>

                        {/* Benefit 2 */}
                        <div className="text-center">
                            <div className="w-12 h-12 bg-lime-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg
                                    className="w-6 h-6 text-lime-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                    />
                                </svg>
                            </div>
                            <h3 className="text-lg font-semibold text-gray-900 mb-2">
                                Secure & Private
                            </h3>
                            <p className="text-gray-500">
                                Your health information is protected and
                                confidential
                            </p>
                        </div>

                        {/* Benefit 3 */}
                        <div className="text-center">
                            <div className="w-12 h-12 bg-lime-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg
                                    className="w-6 h-6 text-lime-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                                    />
                                </svg>
                            </div>
                            <h3 className="text-lg font-semibold text-gray-900 mb-2">
                                Professional Care
                            </h3>
                            <p className="text-gray-500">
                                Access to qualified healthcare professionals
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
}
