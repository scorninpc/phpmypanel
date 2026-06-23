<?php

namespace Application\Main\Helpers\View;

/**
 * Faz o tratamento de datas, em varios formatos diferentes
 */
class DateFormat
{
	protected $config;

	public function __construct($config)
	{
		$this->config = $config;
	}

	public function call($format, $date, $use_timestamp=FALSE)
	{
		$new_date = $format;

		if($format != "%A") {
			// Busca o timestamp da data
			$timestamp = $date;
			if(!$use_timestamp) {
				$timestamp = strtotime($date);
			}
			else {
				$date = date("Y-m-d H:i:s", $date);
			}
			
			// Cria o vetor de dias da semana
			$week = array();
			$week[7] = "domingo";
			$week[1] = "segunda-feira";
			$week[2] = "terça-feira";
			$week[3] = "quarta-feira";
			$week[4] = "quinta-feira";
			$week[5] = "sexta-feira";
			$week[6] = "sabado";
			$new_date = str_replace("%E", $week[date("N", $timestamp)], $new_date);

			// Cria o vetor de dias da semana curto
			$week = [];
			$week[7] = "domingo";
			$week[1] = "segunda";
			$week[2] = "terça";
			$week[3] = "quarta";
			$week[4] = "quinta";
			$week[5] = "sexta";
			$week[6] = "sabado";
			$new_date = str_replace("%e", $week[date("N", $timestamp)], $new_date);
			
			// Cria o vetor dos meses por extenso e abreviação
			$month = array();
			$month[1] = "janeiro";
			$month[2] = "fevereiro";
			$month[3] = "março";
			$month[4] = "abril";
			$month[5] = "maio";
			$month[6] = "junho";
			$month[7] = "julho";
			$month[8] = "agosto";
			$month[9] = "setembro";
			$month[10] = "outubro";
			$month[11] = "novembro";
			$month[12] = "dezembro";
			$new_date = str_replace("%F", $month[date("n", $timestamp)], $new_date);
			$new_date = str_replace("%M", substr($month[date("n", $timestamp)], 0, 3), $new_date);
			
			// Troca as informacoes basicas
			$new_date = str_replace("%Y", date("Y", $timestamp), $new_date);
			$new_date = str_replace("%y", date("y", $timestamp), $new_date);
			$new_date = str_replace("%d", date("d", $timestamp), $new_date);
			$new_date = str_replace("%m", date("m", $timestamp), $new_date);
			$new_date = str_replace("%H", date("H", $timestamp), $new_date);
			$new_date = str_replace("%i", date("i", $timestamp), $new_date);
			$new_date = str_replace("%s", date("s", $timestamp), $new_date);

			// Verifica se tem o %P
			$new_date = str_replace("%P", $this->timepass($date, TRUE), $new_date);
			$new_date = str_replace("%p", $this->timepass($date, FALSE), $new_date);
		}

		// Converte o tempo decimal para minutos
		$new_date = str_replace("%A", $this->tempoamigavel($date), $new_date);
				
		// Retorna a string formatada
		return $new_date;
	}

	/**
	 * converte o tempo de decimal para horario, por exemplo 1,5 em 01:30
	 */
	public function tempoamigavel($tempo)
	{
		$hora = (int)$tempo;
		$minutos = ($tempo - $hora) * 100;

		$minutos = (int) ((60 * $minutos) / 100);
		
		return sprintf("%02d:%02d", $hora, $minutos);
	}

	/**
	 *
	 */
	private function translateMes($mes)
	{
		$month = [
			1 => "janeiro",
			2 => "fevereiro",
			3 => "março",
			4 => "abril",
			5 => "maio",
			6 => "junho",
			7 => "julho",
			8 => "agosto",
			9 => "setembro",
			10 => "outubro",
			11 => "novembro",
			12 => "dezembro"
		];

		return $month[$mes];
	}

	/**
	 * Retorna quanto tempo se passou do tempo enviado
	 */
	private function timepass($time, $extended)
	{
		// date_default_timezone_set('America/Sao_Paulo');
 		// setlocale(LC_ALL, array('pt_BR.iso-8859-1', 'pt.UTF-8'));
 		// setlocale(LC_ALL, ["pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese"]);


		 try {
			$start_date = new \DateTime($time);
		}
		catch(\Exception $e) {
			return $time;
		}
		
		$since_start = $start_date->diff(new \DateTime());

		if($since_start->y == 1) {
			$return = "à " . $since_start->y . " ano atrás";
			if($extended) {
				$return .= ", em " . $start_date->format("d") . " de " . $this->translateMes($start_date->format("n")) . " de " . $start_date->format("Y") . " às " . $start_date->format("H:i");
			}
			return $return;
		}
		else if($since_start->y > 1) {
			$return = "à " . $since_start->y . " anos atrás";
			if($extended) {
				$return .= ", em " . $start_date->format("d") . " de " . $this->translateMes($start_date->format("n")) . " de " . $start_date->format("Y") . " às " . $start_date->format("H:i");
			}
			return $return;
		}
		else if($since_start->m == 1) {
			$return = "à " . $since_start->m . " mês atrás";
			if($extended) {
				$return .= ", em " . $start_date->format("d") . " de " . $this->translateMes($start_date->format("n")) . " às " . $start_date->format("H:i");
			}
			return $return;
		}
		else if($since_start->m > 1) {
			$return = "à " . $since_start->m . " meses atrás";
			if($extended) {
				$return .= ", em " . $start_date->format("d") . " de " . $this->translateMes($start_date->format("n")) . " às " . $start_date->format("H:i");
			}
			return $return;
		}

		if($since_start->d == 1) {
			$return = "à " . $since_start->d . " dia atrás";
			if($extended) {
				$return .= ", em " . $start_date->format("H:i");
			}
			return $return;
		}
		else if($since_start->d > 1) {
			$return = "à " . $since_start->d . " dias atrás";
			if($extended) {
				$return .= ", às " . $start_date->format("H:i");
			}
			return $return;
		}

		if($since_start->h == 1) {
			return "à " . $since_start->h . " hora atrás";
		}
		else if($since_start->h > 1) {
			return "à " . $since_start->h . " horas atrás";
		}

		if($since_start->i == 1) {
			return "à " . $since_start->i . " minuto atrás";
		}
		else if($since_start->i > 1) {
			return "à " . $since_start->i . " minutos atrás";
		}

		return "à menos de um minuto atrás";
	}
}