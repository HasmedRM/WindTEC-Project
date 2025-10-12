import { SVGAttributes } from 'react';

export default function AppLogoIcon(props: SVGAttributes<SVGElement>) {
    return (
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="lucide lucide-wind-icon lucide-wind" {...props}>
            <path d="M12.8 19.6A2 2 0 1 0 14 16H2"/>
            <path d="M17.5 8a2.5 2.5 0 1 1 2 4H2"/>
            <path d="M9.8 4.4A2 2 0 1 1 11 8H2"/>
        </svg>
    );
}
