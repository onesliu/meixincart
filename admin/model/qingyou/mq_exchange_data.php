<?php
class ModelQingyouMqExchangeData extends Model
{
	public function updateData($type)
    {
        if      ( $type == 1 )
        {
        }
        else if ( $type == 2 )  // 调价
        {
            $this->log->write("post=");
            $this->log->write($this->request->post);
        }
        else if ( $type == 3 )
        {
        }
        else if ( $type == 4 )
        {
        }
        else if ( $type == 5 )
        {
        }
	}
}