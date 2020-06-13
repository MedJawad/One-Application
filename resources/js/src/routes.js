import Dashboard from "./views/Dashboard.jsx";
import LocationFilesList from "./views/LocationFilesList";
import ReviewFilesList from "./views/ReviewFilesList";

const dashboardRoutes = [
    {
        path: "/newRapport",
        name: "Nouveau Rapport",
        icon: "pe-7s-graph",
        component: Dashboard,
        layout: "/admin"
    },
    {
        path: "/barrages",
        name: "Barrages",
        icon: "pe-7s-note2",
        component: LocationFilesList,
        layout: "/admin"
    },
    {
        path: "/eoliennes",
        name: "Eoliennes",
        icon: "pe-7s-note2",
        component: ReviewFilesList,
        layout: "/admin"
    }
];

export default dashboardRoutes;
