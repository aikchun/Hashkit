<div class="hashResults view">

	<?php 
			//base - result from database (total hashes)
			//exponent - result from database (total hashes)
			//requiredbase - sample size base 
			//requiredexponent - sample size exponent
			//customizedalgorithmbase - base for (total hashes)
			//customizedalgorithmexponent - exponent for (total hashes)
			//samplespace - sample size hashes in value 
			//totalhash - size in total hashes

			if((int)$requiredbase != 0 && (int)$requiredexponent != 0){

				if((int)$customizedalgorithmbase == 0 && (int)$customizedalgorithmexponent == 0 && (int)$base == 0 && (int)$exponent == 0){
					echo "For the sample space of " . '<font color="red">'. $requiredbase . $requiredexponent . '<font color="black">'. " and the total size of hash function output " . '<font color="red">'. $totalhash . '<font color="black">' . ",";
				}elseif((int)$customizedalgorithmbase != 0 && (int)$customizedalgorithmexponent != 0 && (int)$base == 0 && (int)$exponent == 0){
					echo "For the sample space of " . '<font color="red">'. $requiredbase . $requiredexponent . '<font color="black">'. " and the total size of hash function output " . '<font color="red">'. $customizedalgorithmbase . $customizedalgorithmexponent . '<font color="black">' . ",";

				}else{
					echo "For the sample space of " . '<font color="red">'. $requiredbase . $requiredexponent .'<font color="black">'. " and the total size of hash function output " . '<font color="red">'. $base . $exponent . '<font color="black">' . ",";
				}

			}else {

				if((int)$customizedalgorithmbase == 0 && (int)$customizedalgorithmexponent == 0 && (int)$base == 0 && (int)$exponent == 0){
					echo "For the sample space of " . '<font color="red">'. $samplespace . '<font color="black">'. " and the total size of hash function output " . '<font color="red">'. $totalhash . '<font color="black">' . ",";
				}elseif((int)$customizedalgorithmbase != 0 && (int)$customizedalgorithmexponent != 0 && (int)$base == 0 && (int)$exponent == 0){
					echo "For the sample space of " . '<font color="red">'. $samplespace . '<font color="black">'. " and the total size of hash function output " . '<font color="red">'. $customizedalgorithmbase . $customizedalgorithmexponent . '<font color="black">' . ",";

				}else{
					echo "For the sample space of " . '<font color="red">'. $samplespace .'<font color="black">'. " and the total size of hash function output " . '<font color="red">'. $base . $exponent . '<font color="black">' . ",";
				}
				
			}
	
	?>
	<br>

	<?php echo "the probability of getting a collision in numbers of tries: " . round($probability,2) . " %"; ?>
	<br>

	<?php echo "the required sample space to get 99% probability of getting a collision: " . $requiredsamplespace . " hashes" ?>
	<br>
	<button> <a href="/HashTests/calculate_probability_of_collision"> <- </a> </button>
	<button> <a href="/pages/hash_function_properties"> home </a> </button>

</div>
