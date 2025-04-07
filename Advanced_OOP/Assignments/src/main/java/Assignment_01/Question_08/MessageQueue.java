package Assignment_01.Question_08;
/**
    A first-in, first-out bounded collection of messages.
*/
public class MessageQueue
{
   /**
       Constructs an empty message queue.
       @param capacity the maximum capacity of the queue
       @precondition capacity > 0;
   */
   public MessageQueue(int capacity)
   {
      elements = new Message[capacity];
      count = 0;
      head = 0;
      tail = 0;
   }

   /**
       Remove message at head.
       @return the message that has been removed from the queue
       @precondition size() > 0;
   */
   public Message removeFirst()
   {
      Message r = elements[head];
      head = (head + 1) % elements.length;
      count--;
      return r;
   }

   /**
       Append a message at tail.
       @param aMessage the message to be appended
       @precondition size() < getCapacity();
   */
   public void add(Message aMessage)
   {
      elements[tail] = aMessage;
      if(count >= elements.length)
         this.resize();

      tail = (tail + 1) % elements.length;
      count++;
   }

   /**
    * Double the size from previous queue, copy messages to the new
    * array and set the position for head and tail.
    * */
   public void resize(){
      Message[] newElements = new Message[elements.length * 2];

      for(int i=0; i<count; i++){
         int idx = ( head + i ) % elements.length;
         newElements[i] = elements[idx];
      }

      elements = newElements;
      head = 0;
      tail = count;
   }

   /**
       Get the total number of messages in the queue.
       @return the total number of messages in the queue
   */
   public int size()
   {
      return count;
   }

   /**
       Get the maximum number of messages in the queue.
       @return the capacity of the queue
   */
   public int getCapacity()
   {
      return elements.length;
   }


   /**
       Get message at head.
       @return the message that is at the head of the queue
       @precondition size() > 0
   */
   public Message getFirst()
   {
      return elements[head];
   }

   private Message[] elements;
   private int head;
   private int tail;
   private int count;
}
