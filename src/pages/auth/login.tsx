import {
	AlertCircle,
	CheckCircle2,
	Lock,
	LogIn,
	Mail,
	ShieldCheck,
} from "lucide-react";
import { type FormEvent, useState } from "react";
import { Link } from "react-router-dom";
import { Alert, AlertDescription } from "@/components/ui/alert";
import { Button } from "@/components/ui/button";
import {
	Card,
	CardContent,
	CardDescription,
	CardHeader,
	CardTitle,
} from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { useLogin } from "../../hooks/useAuth";

export default function LoginPage() {
	const loginMutation = useLogin();

	const [emailOrContact, setEmailOrContact] = useState("");
	const [password, setPassword] = useState("");
	const [validationError, setValidationError] = useState<string | null>(null);

	const handleSubmit = async (e: FormEvent) => {
		e.preventDefault();
		setValidationError(null);

		if (!emailOrContact.trim() || !password.trim()) {
			setValidationError("Por favor, preencha todos os campos");
			return;
		}

		loginMutation.mutate({ emailOrContact, password });
	};

	const errorMessage = validationError || loginMutation.error?.message;
	const successMessage = loginMutation.isSuccess
		? loginMutation.data?.message
		: null;

	return (
		<div className="min-h-screen flex items-center justify-center bg-linear-to-br from-blue-500 to-purple-500 p-4">
			<Card className="w-full max-w-md shadow-2xl">
				<CardHeader className="space-y-2 text-center">
					<div className="mx-auto w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-2">
						<ShieldCheck className="w-8 h-8 text-primary" />
					</div>
					<CardTitle className="text-3xl font-bold">
						Automo BackOffice
					</CardTitle>
					<CardDescription className="text-base">
						Faça login para acessar o sistema
					</CardDescription>
				</CardHeader>

				<CardContent>
					<form onSubmit={handleSubmit} className="space-y-4">
						{/* Success Display */}
						{successMessage && (
							<Alert className="bg-green-50 border-green-200 dark:bg-green-900/20 dark:border-green-800">
								<CheckCircle2 className="h-4 w-4 text-green-600 dark:text-green-400" />
								<AlertDescription className="text-green-800 dark:text-green-200">
									{successMessage}
								</AlertDescription>
							</Alert>
						)}

						{/* Error Display */}
						{errorMessage && (
							<Alert variant="destructive">
								<AlertCircle className="h-4 w-4" />
								<AlertDescription>{errorMessage}</AlertDescription>
							</Alert>
						)}

						{/* Email/Contact Field */}
						<div className="space-y-2">
							<Label htmlFor="email" className="flex items-center gap-2">
								<Mail className="w-4 h-4" />
								Email ou Contacto
							</Label>
							<Input
								type="text"
								name="email"
								placeholder="Digite seu email ou contacto"
								value={emailOrContact}
								onChange={(e) => setEmailOrContact(e.target.value)}
								required
								autoComplete="email"
								autoFocus
								disabled={loginMutation.isPending}
								className="h-11"
							/>
						</div>

						{/* Password Field */}
						<div className="space-y-2">
							<Label htmlFor="password" className="flex items-center gap-2">
								<Lock className="w-4 h-4" />
								Senha
							</Label>
							<Input
								type="password"
								name="password"
								placeholder="Digite sua senha"
								value={password}
								onChange={(e) => setPassword(e.target.value)}
								required
								autoComplete="current-password"
								disabled={loginMutation.isPending}
								className="h-11"
							/>
						</div>

						{/* Submit Button */}
						<Button
							type="submit"
							className="w-full h-11 text-base"
							disabled={loginMutation.isPending}
						>
							{loginMutation.isPending ? (
								<>
									<div className="mr-2 h-4 w-4 animate-spin rounded-full border-2 border-current border-t-transparent" />
									Autenticando...
								</>
							) : (
								<>
									<LogIn className="mr-2 h-4 w-4" />
									Entrar
								</>
							)}
						</Button>

						{/* Forgot Password Link */}
						<div className="text-center pt-2">
							<Link
								to="/forgot-password"
								className="text-sm text-muted-foreground hover:text-primary transition-colors inline-flex items-center gap-1"
							>
								<AlertCircle className="w-3.5 h-3.5" />
								Esqueceu sua senha?
							</Link>
						</div>

						{/* Security Notice */}
						<div className="text-center pt-2 border-t">
							<p className="text-xs text-muted-foreground flex items-center justify-center gap-1.5">
								<ShieldCheck className="w-3.5 h-3.5" />
								Acesso seguro ao sistema BackOffice
							</p>
						</div>
					</form>
				</CardContent>
			</Card>
		</div>
	);
}
