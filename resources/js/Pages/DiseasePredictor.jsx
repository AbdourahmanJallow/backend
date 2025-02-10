import { useEffect, useState } from "react";
import { Head, useForm } from "@inertiajs/react";
import axios from "axios";

async function predictDisease(symptoms) {
    // Simulate API call
    await new Promise((resolve) => setTimeout(resolve, 2000));

    // Mock prediction logic - in reality this would be your Laravel endpoint
    const commonConditions = {
        "fever,headache,fatigue": "Common Cold",
        "fever,cough,shortness of breath": "COVID-19",
        "headache,nausea,sensitivity to light": "Migraine",
        "stomach pain,nausea,vomiting": "Gastroenteritis",
    };

    const symptomKey = symptoms.sort().join(",").toLowerCase();
    return (
        commonConditions[symptomKey] ||
        "Unable to determine condition. Please consult a healthcare professional."
    );
}

export default function DiseasePredictor({ flash }) {
    // const [symptoms, setSymptoms] = useState("");
    const [prediction, setPrediction] = useState(null);
    const [error, setError] = useState(null);
    const [isLoading, setIsLoading] = useState(false);
    const { data, setData, post, reset } = useForm({
        symptoms: "",
    });

    useEffect(() => {
        console.log("Flash data:", flash);
        console.log("Prediction:", prediction);
    }, [flash, prediction]);

    const handleSubmit = async (e) => {
        e.preventDefault();
        setError(null);
        setPrediction(null);

        // Basic validation
        if (!data.symptoms.trim()) {
            setError("Please enter symptoms");
            return;
        }

        // Parse symptoms
        const symptomsList = data.symptoms
            .split(",")
            .map((s) => s.trim())
            .filter((s) => s.length > 0);

        if (symptomsList.length === 0) {
            setError("Please enter valid symptoms separated by commas.");
            return;
        }

        setIsLoading(true);
        try {
            const response = await axios.post("/predict-disease", data);
            setPrediction(response.data.predicted_disease);
            // reset();
        } catch (error) {
            setError("Failed to predict disease.");
            console.error(error);
        } finally {
            setIsLoading(false);
        }

        // try {
        //     post("/predict-disease", data, {
        //         onSuccess: (page) => {
        //             const predictedDisease =
        //                 page.props.flash?.predicted_disease;

        //             setPrediction(page.props.flash?.predicted_disease);

        //             console.log(
        //                 `predictedDisease ${page.props.flash?.predicted_disease}`
        //             );

        //             setIsLoading(false);
        //             // reset();
        //         },
        //         onError: (err) => {
        //             console.log(err);
        //         },
        //     });

        //     console.log(prediction);
        //     setIsLoading(false);
        // } catch (error) {
        //     console.log(error);
        //     setError("An error occurred while predicting the disease");
        //     setIsLoading(false);
        // }
    };

    return (
        <>
            <Head title="Disease Predictor" />

            <div className="min-h-screen bg-lime- p-4 flex items-center justify-center">
                <div className="w-full max-w-xl bg-white rounded-lg shadow-lg shadow-lime-100 border border-lime-200">
                    {/* Header */}
                    <div className="p-6 border-b border-lime-100">
                        <h1 className="text-2xl font-bold text-lime-800">
                            Disease Predictor
                        </h1>
                        <p className="mt-2 text-lime-600">
                            Enter your symptoms separated by commas (e.g.,
                            fever, headache, fatigue)
                        </p>
                    </div>

                    {/* Content */}
                    <div className="p-6">
                        <form onSubmit={handleSubmit} className="space-y-4">
                            <div>
                                <textarea
                                    placeholder="Enter symptoms here..."
                                    value={data.symptoms}
                                    onChange={(e) =>
                                        setData({ symptoms: e.target.value })
                                    }
                                    className="w-full min-h-[100px] rounded-lg border border-lime-200 p-3 focus:outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400 disabled:opacity-50 disabled:cursor-not-allowed"
                                    disabled={isLoading}
                                />
                            </div>

                            <button
                                type="submit"
                                disabled={isLoading}
                                className="w-full bg-lime-500 hover:bg-lime-600 text-white py-2 px-4 rounded-lg font-medium transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center"
                            >
                                {isLoading ? (
                                    <>
                                        <svg
                                            className="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                        >
                                            <circle
                                                className="opacity-25"
                                                cx="12"
                                                cy="12"
                                                r="10"
                                                stroke="currentColor"
                                                strokeWidth="4"
                                            />
                                            <path
                                                className="opacity-75"
                                                fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                            />
                                        </svg>
                                        Analyzing Symptoms...
                                    </>
                                ) : (
                                    "Predict Disease"
                                )}
                            </button>

                            {error && (
                                <div className="rounded-lg border border-red-200 bg-red-50 p-4">
                                    <div className="flex items-center">
                                        <svg
                                            className="h-5 w-5 text-red-600 mr-2"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                        >
                                            <path
                                                fillRule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clipRule="evenodd"
                                            />
                                        </svg>
                                        <div>
                                            <h3 className="text-red-800 font-medium">
                                                Error
                                            </h3>
                                            <p className="text-red-600">
                                                {error}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            )}

                            {prediction && (
                                <div className="rounded-lg border border-lime-200 bg-lime-50 p-4">
                                    <h3 className="text-lime-800 font-medium">
                                        Predicted Condition
                                    </h3>
                                    <p className="text-lime-700 font-medium mt-1">
                                        {prediction}
                                    </p>
                                </div>
                            )}

                            {prediction && (
                                <div className="text-sm text-lime-600 bg-lime-50 p-4 rounded-lg border border-lime-200">
                                    <strong className="block mb-1 text-lime-800">
                                        Important Note:
                                    </strong>
                                    This is a basic prediction tool and should
                                    not be used as a substitute for professional
                                    medical advice. Please consult with a
                                    healthcare provider for proper diagnosis and
                                    treatment.
                                </div>
                            )}
                        </form>
                    </div>
                </div>
            </div>
        </>
    );
}
