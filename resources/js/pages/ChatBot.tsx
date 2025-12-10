import React, { useEffect, useRef, useState } from 'react';
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import ReactMarkdown from 'react-markdown'; // <--- Importamos a biblioteca aqui

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Chat Bot',
        href: dashboard().url,
    },
];

type Message = { role: 'user' | 'bot'; text: string };

export default function ChatBot() {
    const [messages, setMessages] = useState<Message[]>([]);
    const [input, setInput] = useState('');
    const [loading, setLoading] = useState(false);
    const scrollRef = useRef<HTMLDivElement | null>(null);

    // Scroll automático
    useEffect(() => {
        if (scrollRef.current) {
            scrollRef.current.scrollTop = scrollRef.current.scrollHeight;
        }
    }, [messages, loading]);

    async function sendMessage(e?: React.FormEvent) {
        e?.preventDefault();
        if (!input.trim()) return;
        
        const text = input.trim();
        // Adiciona mensagem do usuário
        setMessages((m) => [...m, { role: 'user', text }]);
        setInput('');
        setLoading(true);

        try {
            const res = await fetch('/api/chat.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ message: text }),
            });

            if (!res.ok) {
                const t = await res.text();
                throw new Error(t || 'Erro na requisição');
            }

            const data = await res.json();
            const answer = data && data.answer ? data.answer : data.error || 'Sem resposta';
            
            // Adiciona resposta do bot
            setMessages((m) => [...m, { role: 'bot', text: answer }] );
        } catch (err: any) {
            setMessages((m) => [...m, { role: 'bot', text: 'Erro: ' + (err?.message ?? String(err)) }]);
        } finally {
            setLoading(false);
        }
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Chat Bot" />

            <div className="overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                <div className="p-4">
                    <h3 className="mb-4 text-lg font-semibold">DecoBot</h3>
                    <p className="text-sm text-muted-foreground mb-4">Especialista em Guindastes & Rigging</p>

                    {/* Área de Mensagens */}
                    <div 
                        ref={scrollRef} 
                        className="flex-1 overflow-auto p-6 space-y-6 bg-gray-50 dark:bg-[#343541] border dark:border-transparent rounded-md"
                        style={{ minHeight: '60vh' }}
                    >
                        {/* empty state removed per request */}

                        {messages.map((m, i) => (
                            <div key={i} className={`flex ${m.role === 'user' ? 'justify-end' : 'justify-start'}`}>
                                <div 
                                    className={`max-w-[85%] px-5 py-3 rounded-2xl shadow-sm text-sm leading-7 ${
                                        m.role === 'user' 
                                            ? 'bg-zinc-700 text-white rounded-br-none' 
                                            : 'bg-white dark:bg-[#444654] text-gray-800 dark:text-gray-100 rounded-bl-none border dark:border-gray-600/50'
                                    }`}
                                >
                                    {/* Renderização Condicional: Texto puro pro usuário, Markdown pro Bot */}
                                    {m.role === 'user' ? (
                                        <p>{m.text}</p>
                                    ) : (
                                        <ReactMarkdown
                                            components={{
                                                // Mapeamento de tags HTML para classes Tailwind
                                                ul: ({node, ...props}) => <ul className="list-disc pl-5 my-2 space-y-1" {...props} />,
                                                ol: ({node, ...props}) => <ol className="list-decimal pl-5 my-2 space-y-1" {...props} />,
                                                li: ({node, ...props}) => <li className="pl-1" {...props} />,
                                                strong: ({node, ...props}) => <strong className="font-bold text-gray-900 dark:text-white" {...props} />,
                                                p: ({node, ...props}) => <p className="mb-2 last:mb-0" {...props} />,
                                                h1: ({node, ...props}) => <h1 className="text-xl font-bold my-2" {...props} />,
                                                h2: ({node, ...props}) => <h2 className="text-lg font-bold my-2" {...props} />,
                                            }}
                                        >
                                            {m.text}
                                        </ReactMarkdown>
                                    )}
                                </div>
                            </div>
                        ))}

                        {/* Indicador de Digitando */}
                        {loading && (
                            <div className="flex justify-start animate-pulse">
                                <div className="bg-gray-200 dark:bg-gray-800 px-4 py-3 rounded-2xl rounded-bl-none text-gray-500 text-sm italic">
                                    Consultando manuais técnicos...
                                </div>
                            </div>
                        )}
                    </div>

                    {/* Input */}
                    <form onSubmit={sendMessage} className="mt-4">
                        <div className="flex items-center gap-3 bg-transparent">
                            <input
                                className="flex-1 px-4 py-3 rounded-full border border-transparent bg-[#0b0b0d] text-white placeholder:text-gray-400 focus:ring-2 focus:ring-[#4b5563] focus:border-transparent outline-none transition-all"
                                value={input}
                                onChange={(e) => setInput(e.target.value)}
                                placeholder={loading ? 'Aguarde a resposta...' : 'Digite sua pergunta...'}
                                disabled={loading}
                            />
                            <button
                                type="submit"
                                disabled={loading || !input.trim()}
                                className={`p-3 rounded-full text-white transition-all ${
                                    loading || !input.trim() 
                                    ? 'bg-zinc-600 cursor-not-allowed' 
                                    : 'bg-zinc-800 hover:bg-zinc-700 shadow-md hover:shadow-lg'
                                }`}
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={2} stroke="currentColor" className="w-5 h-5">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </AppLayout>
    );
}