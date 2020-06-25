import React from "react";
import { FcDam, FcFactory } from "react-icons/fc";
import {
    FaSolarPanel,
    FaThermometerHalf,
    FaDownload,
    FaFolder,
    FaGasPump
} from "react-icons/fa";
import { GiPaperWindmill, GiCrossedSwords, GiSplitCross } from "react-icons/gi";
import { MdCreateNewFolder } from "react-icons/md";
import NewReport from "./views/user/NewReport.jsx";
import NewCentrale from "./views/admin/NewCentrale";
import DownloadReport from "./views/admin/DownloadReport";
import CentralesList from "./views/admin/CentralesList.jsx";
import ReportsList from "./views/user/ReportsList.jsx";
export const userRoutes = [
    {
        path: "/admin/newReport",
        name: "Nouveau Rapport",
        icon: <MdCreateNewFolder />, //"pe-7s-note2",
        // component: NewReport,
        render: props => <NewReport {...props} />
    },
    {
        path: "/admin/reports",
        name: "Voir Rapports",
        icon: <FaFolder />, //"pe-7s-note2",
        // component: NewReport,
        render: props => <ReportsList {...props} />
    }
];
export const pchRoutes = [
    // {
    //   path: "/newReport",
    //   name: "Nouveau Rapport",
    //   icon: "pe-7s-note2",
    //   component: NewReport,
    //   layout: "/admin",
    // },
    {
        path: "/admin/barrages",
        name: "Barrages",
        icon: "pe-7s-graph"
        // component: LocationFilesList,
    },
    {
        path: "/admin/eoliennes",
        name: "Parc Eoliens",
        icon: "pe-7s-diskette"
        // component: ReviewFilesList,
    }
];
export const adminRoutes = [
    // {
    //     path: "/admin/newCentrale",
    //     name: "Nouvelle Centrale",
    //     icon: <MdCreateNewFolder size={30} />, //"pe-7s-note2",
    //     // component: NewCentrale,
    //     render: props => <NewCentrale {...props} />
    // },
    {
        path: "/admin/getReport",
        name: "Telecharger Rapport",
        icon: <FaDownload size={30} />, //"pe-7s-note2",
        // component: ReportsList,
        render: props => <DownloadReport {...props} />
    },
    {
        path: "/admin/barrages",
        name: "Barrages",
        icon: <FcDam size={30} />, //"pe-7s-graph",//FcDam
        // component: CentralesList,
        render: props => <CentralesList {...props} type="barrage" />
    },
    {
        path: "/admin/eoliens",
        name: "Parc Eoliens",
        icon: <GiPaperWindmill size={30} />, //"pe-7s-diskette",//GiPaperWindmill
        // component: CentralesList,
        render: props => <CentralesList {...props} type={"eolien"} />
    },
    {
        path: "/admin/solaire",
        name: "Energie Solaire",
        icon: <FaSolarPanel size={30} />, //"pe-7s-graph", //FaSolarPanel
        // component: CentralesList,
        render: props => <CentralesList {...props} type={"solaire"} />
    },
    {
        path: "/admin/cycleCombine",
        name: "Cycle Combiné",
        icon: <FcFactory size={30} />, // "pe-7s-diskette",
        // component: ReviewFilesList,
        render: props => <CentralesList {...props} type={"cycle combine"} />
    },
    {
        path: "/admin/charbon",
        name: "Th.Charbon",
        icon: <FaThermometerHalf size={30} />, // "pe-7s-diskette",
        // component: CentralesList,
        render: props => (
            <CentralesList {...props} type={"thermique a charbon"} />
        )
    },
    {
        path: "/admin/gaz",
        name: "T.A.G",
        icon: <FaGasPump size={30} />, // "pe-7s-diskette",
        // component: CentralesList,
        render: props => <CentralesList {...props} type={"turbine a gaz"} />
    },
    {
        path: "/admin/interconnexions",
        name: "Interconnexions",
        icon: <GiSplitCross size={30} />, // "pe-7s-diskette",
        // component: CentralesList,
        render: props => <CentralesList {...props} type={"interconnexion"} />
    }
];
