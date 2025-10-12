// Reuse WindConfig styles and components
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes';
import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, usePage, Link, router } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

const breadcrumbs: BreadcrumbItem[] = [
	{
		title: 'Equipamento Config',
		href: dashboard().url,
	},
];

export default function EquipamentoConfig() {
	const { props } = usePage<SharedData>();

	type Equip = {
		id: number;
		equipamento?: string | null;
		frota?: string | null;
		configuracao?: string | null;
		contrapeso_superestrutura?: string | null;
		contrapeso_chassi_inferior?: string | null;
		contrapeso_ballast?: string | null;
		comprimento_lanca?: string | null;
		luffing_jib?: string | null;
		cs_12m?: string | null;
		cs_14m?: string | null;
		cd_16m?: string | null;
		p4_12m?: string | null;
		p4_14m?: string | null;
		p4_18m?: string | null;
		p4_12m_dolly?: string | null;
		p6_14m?: string | null;
		observacoes?: string | null;
	};

	const equipamentos = (props.equipamentos ?? []) as Equip[];

	return (
		<AppLayout breadcrumbs={breadcrumbs}>
			<Head title="Equipamento Config" />
			{/* Data table */}
			<div className="overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
				<div className="p-4">
					<h3 className="mb-4 text-lg font-semibold">Equipamentos</h3>
					<div className="overflow-x-auto">
						<table className="w-full table-auto text-sm">
							<thead>
								<tr className="text-left">
									<th className="px-3 py-2">ID</th>
									<th className="px-3 py-2">Equipamento</th>
									<th className="px-3 py-2">Frota</th>
									<th className="px-3 py-2">Configuração</th>
									<th className="px-3 py-2">Contrapeso Superestrutura</th>
									<th className="px-3 py-2">Contrapeso Chassi Inferior</th>
									<th className="px-3 py-2">Contrapeso Ballast</th>
									<th className="px-3 py-2">Compr. Lança</th>
									<th className="px-3 py-2">Luffing Jib</th>
									<th className="px-3 py-2">CS 12m</th>
									<th className="px-3 py-2">CS 14m</th>
									<th className="px-3 py-2">CD 16m</th>
									<th className="px-3 py-2">P4 12m</th>
									<th className="px-3 py-2">P4 14m</th>
									<th className="px-3 py-2">P4 18m</th>
									<th className="px-3 py-2">P4 12m Dolly</th>
									<th className="px-3 py-2">P6 14m</th>
									<th className="px-3 py-2">Observações</th>
									<th className="px-3 py-2">Ações</th>
								</tr>
							</thead>
							<tbody>
								{equipamentos.length === 0 && (
									<tr>
										<td colSpan={19} className="px-3 py-6 text-center text-sm text-muted-foreground">
											Nenhum equipamento cadastrado.
										</td>
									</tr>
								)}

								{equipamentos.map((e) => (
									<tr key={e.id} className="odd:bg-muted/50">
										<td className="px-3 py-2">{e.id}</td>
										<td className="px-3 py-2">{e.equipamento ?? '—'}</td>
										<td className="px-3 py-2">{e.frota ?? '—'}</td>
										<td className="px-3 py-2">{e.configuracao ?? '—'}</td>
										<td className="px-3 py-2">{e.contrapeso_superestrutura ?? '—'}</td>
										<td className="px-3 py-2">{e.contrapeso_chassi_inferior ?? '—'}</td>
										<td className="px-3 py-2">{e.contrapeso_ballast ?? '—'}</td>
										<td className="px-3 py-2">{e.comprimento_lanca ?? '—'}</td>
										<td className="px-3 py-2">{e.luffing_jib ?? '—'}</td>
										<td className="px-3 py-2">{e.cs_12m ?? '—'}</td>
										<td className="px-3 py-2">{e.cs_14m ?? '—'}</td>
										<td className="px-3 py-2">{e.cd_16m ?? '—'}</td>
										<td className="px-3 py-2">{e.p4_12m ?? '—'}</td>
										<td className="px-3 py-2">{e.p4_14m ?? '—'}</td>
										<td className="px-3 py-2">{e.p4_18m ?? '—'}</td>
										<td className="px-3 py-2">{e.p4_12m_dolly ?? '—'}</td>
										<td className="px-3 py-2">{e.p6_14m ?? '—'}</td>
										<td className="px-3 py-2">{e.observacoes ?? '—'}</td>
										<td className="px-3 py-2">
											<div className="flex gap-2">
												<Link href={`/equipamentos/${e.id}/editar`} className="text-blue-600">Editar</Link>
												<Button variant="destructive" size="sm" onClick={() => {
													if (!confirm('Tem certeza que deseja deletar este equipamento?')) return;
													router.delete(`/equipamentos/${e.id}`);
												}}>
													Deletar
												</Button>
											</div>
										</td>
									</tr>
								))}
							</tbody>
						</table>
					</div>

					<div className="mt-4 flex justify-end">
						<Button asChild>
							<a href="/equipamentos/criar" className="inline-block">Cadastrar</a>
						</Button>
					</div>
				</div>
			</div>
		</AppLayout>
	);
}
