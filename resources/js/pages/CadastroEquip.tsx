import AppLayout from '@/layouts/app-layout';
import { Head, Form } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { store as equipamentosStore } from '@/routes/equipamentos/index';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/input-error';

export default function CadastroEquip() {
	return (
		<AppLayout>
			<Head title="Cadastro Equipamento" />

			<div className="p-6">
				<h2 className="text-lg font-semibold mb-4">Cadastrar Equipamento</h2>
				<p className="text-sm text-muted-foreground mb-4">Preencha os dados do equipamento e clique em Salvar.</p>

				<Form {...equipamentosStore.form()} method="post" className="grid gap-4">
					{({ processing, errors }) => (
						<>
							<div className="grid md:grid-cols-2 gap-4">
								<div className="grid gap-2">
									<Label htmlFor="equipamento">Equipamento</Label>
									<Input id="equipamento" name="equipamento" type="text" />
									<InputError message={errors.equipamento} />
								</div>

								<div className="grid gap-2">
									<Label htmlFor="frota">Frota</Label>
									<Input id="frota" name="frota" type="text" />
									<InputError message={errors.frota} />
								</div>

								<div className="grid gap-2">
									<Label htmlFor="configuracao">Configuração</Label>
									<Input id="configuracao" name="configuracao" type="text" />
									<InputError message={errors.configuracao} />
								</div>

								<div className="grid gap-2">
									<Label htmlFor="contrapeso_superestrutura">Contrapeso Superestrutura</Label>
									<Input id="contrapeso_superestrutura" name="contrapeso_superestrutura" type="text" />
									<InputError message={errors.contrapeso_superestrutura} />
								</div>

								<div className="grid gap-2">
									<Label htmlFor="contrapeso_chassi_inferior">Contrapeso Chassi Inferior</Label>
									<Input id="contrapeso_chassi_inferior" name="contrapeso_chassi_inferior" type="text" />
									<InputError message={errors.contrapeso_chassi_inferior} />
								</div>

								<div className="grid gap-2">
									<Label htmlFor="contrapeso_ballast">Contrapeso Ballast</Label>
									<Input id="contrapeso_ballast" name="contrapeso_ballast" type="text" />
									<InputError message={errors.contrapeso_ballast} />
								</div>

								<div className="grid gap-2">
									<Label htmlFor="comprimento_lanca">Comprimento Lança</Label>
									<Input id="comprimento_lanca" name="comprimento_lanca" type="text" />
									<InputError message={errors.comprimento_lanca} />
								</div>

								<div className="grid gap-2">
									<Label htmlFor="luffing_jib">Luffing Jib</Label>
									<Input id="luffing_jib" name="luffing_jib" type="text" />
									<InputError message={errors.luffing_jib} />
								</div>

								<div className="grid gap-2">
									<Label htmlFor="cs_12m">CS 12m</Label>
									<Input id="cs_12m" name="cs_12m" type="text" />
									<InputError message={errors.cs_12m} />
								</div>

								<div className="grid gap-2">
									<Label htmlFor="cs_14m">CS 14m</Label>
									<Input id="cs_14m" name="cs_14m" type="text" />
									<InputError message={errors.cs_14m} />
								</div>

								<div className="grid gap-2">
									<Label htmlFor="cd_16m">CD 16m</Label>
									<Input id="cd_16m" name="cd_16m" type="text" />
									<InputError message={errors.cd_16m} />
								</div>

								<div className="grid gap-2">
									<Label htmlFor="p4_12m">P4 12m</Label>
									<Input id="p4_12m" name="p4_12m" type="text" />
									<InputError message={errors.p4_12m} />
								</div>

								<div className="grid gap-2">
									<Label htmlFor="p4_14m">P4 14m</Label>
									<Input id="p4_14m" name="p4_14m" type="text" />
									<InputError message={errors.p4_14m} />
								</div>

								<div className="grid gap-2">
									<Label htmlFor="p4_18m">P4 18m</Label>
									<Input id="p4_18m" name="p4_18m" type="text" />
									<InputError message={errors.p4_18m} />
								</div>

								<div className="grid gap-2">
									<Label htmlFor="p4_12m_dolly">P4 12m Dolly</Label>
									<Input id="p4_12m_dolly" name="p4_12m_dolly" type="text" />
									<InputError message={errors.p4_12m_dolly} />
								</div>

								<div className="grid gap-2">
									<Label htmlFor="p6_14m">P6 14m</Label>
									<Input id="p6_14m" name="p6_14m" type="text" />
									<InputError message={errors.p6_14m} />
								</div>

								<div className="md:col-span-2 grid gap-2">
									<Label htmlFor="observacoes">Observações</Label>
									<textarea id="observacoes" name="observacoes" className="min-h-[100px] rounded-md border px-3 py-2 text-sm" placeholder="Observações sobre o equipamento" />
									<InputError message={errors.observacoes} />
								</div>
							</div>

							<div className="flex justify-end">
								<Button type="submit" disabled={processing}>
									{processing ? 'Salvando...' : 'Salvar'}
								</Button>
							</div>
						</>
					)}
				</Form>
			</div>
		</AppLayout>
	);
}
