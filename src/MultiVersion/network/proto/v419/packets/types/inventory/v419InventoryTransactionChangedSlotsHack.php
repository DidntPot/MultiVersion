<?php

namespace MultiVersion\network\proto\v419\packets\types\inventory;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class v419InventoryTransactionChangedSlotsHack{

	/**
	 * @param int[] $changedSlotIndexes
	 */
	public function __construct(
		private int $containerId,
		private array $changedSlotIndexes
	){
	}

	public function getContainerId() : int{ return $this->containerId; }

	/** @return int[] */
	public function getChangedSlotIndexes() : array{ return $this->changedSlotIndexes; }

	public static function read(PacketSerializer $in) : self{
		$containerId = v419ContainerUIIds::read($in);
		$changedSlots = [];
		for($i = 0, $len = $in->getUnsignedVarInt(); $i < $len; ++$i){
			$changedSlots[] = $in->getByte();
		}
		return new self($containerId, $changedSlots);
	}

	public function write(PacketSerializer $out) : void{
		v419ContainerUIIds::write($out, $this->containerId);
		$out->putUnsignedVarInt(count($this->changedSlotIndexes));
		foreach($this->changedSlotIndexes as $index){
			$out->putByte($index);
		}
	}
}